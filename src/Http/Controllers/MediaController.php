<?php

namespace Plank\MediaManager\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Plank\Mediable\Exceptions\MediaMoveException;
use Plank\MediaManager\Http\Requests\MediaStoreRequest;
use Plank\MediaManager\Http\Requests\MediaUpdateRequest;
use Plank\MediaManager\Models\Media;
use Plank\Mediable\MediaUploader;
use Plank\MediaManager\MediaManager;

class MediaController extends BaseController
{
    protected $manager;

    protected $model;

    protected $uploader;

    /**
     *
     * @var array $ignore Directories, of format "path/relative/to/disk/root" to be ignored for display in the media manager.
     */
    protected $ignore = ["conversions"];

    public function __construct(MediaUploader $uploader, array $ignore = [])
    {
        $this->manager = new MediaManager();
        $this->model = config('media-manager.model');
        $this->uploader = $uploader;
        $this->ignore = array_merge($ignore, $this->ignore);
    }

    /**
     * Retrieve details about a specific piece of media.
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id)
    {
        return response($this->model::findOrFail($id));
    }

    /**
     * List all files and subdirectories contained within $path.
     *
     * @param  Request  $request
     * @param $path
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Plank\MediaManager\Exceptions\MediaManagerException
     */
    public function index(Request $request, $path = "")
    {
        $diskString = $this->manager->verifyDisk($request->disk);
        $disk = Storage::disk($diskString);
        $path = $this->manager->verifyDirectory($diskString, $path);
        $model = config('media-manager.model');

        $media = $model::inDirectory($diskString, $path)->paginate(20)->toArray();
        $subdirectories = array_diff($disk->directories($path), $this->ignore);

        $key = trim("root." . implode(".", explode('/', $path)), "\.");
        // Get the timestamp for each directory. This can probably be improved later.
        $subdirectories = Cache::remember("media.manager.folders.{$key}", 60*60*24, function () use ($disk, $subdirectories) {
            // Check the files immediately in the chosen folder, grab the most recent modified time, report this as the timestamp
            $modified = Media::whereIn("directory", $subdirectories)
                ->selectRaw('directory, max(updated_at) as timestamp')
                ->groupBy("directory")
                ->get()
                ->map(function ($directory) {
                    return [
                        'name' => $directory->directory,
                        'timestamp' => $directory->timestamp
                    ];
                });
            // If a directory was not included in the list, it was probably empty, or only had files in it, so we just
            // report that we cannot resolve the timestamp.
            foreach (array_diff($subdirectories, $modified->pluck('name')->toArray()) as $leftover) {
                $modified[] = ['name' => $leftover, 'timestamp' => "N/A"];
            }
                return $modified->sortBy('name')->values();
        });

        return response(['subdirectories' => $subdirectories->sortBy('name'), 'media' => $media['data'], 'page_count' => $media['last_page']]);
    }

    /**
     * Upload a piece of media to a specified path, and create associated media entry representing it.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Plank\MediaManager\Exceptions\MediaManagerException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\ConfigurationException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileExistsException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileNotFoundException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileNotSupportedException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileSizeException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\ForbiddenException
     */
    public function create(MediaStoreRequest $request)
    {
        // Set up data we need for uploads, turn file into an array so we can always iterate over it.
        $media = is_array($request->file) ? $request->file : [$request->file] ;
        $data = collect($request->only(['title', 'alt', 'caption', 'credit']));
        $disk = $this->manager->verifyDisk($request->disk);
        $path = $this->manager->verifyDirectory($disk, trim($request->path, "/"));
        $response = [];


        foreach ($media as $m) {

            // Prep an uploader instance with the file.
            $model = $this->uploader
                ->toDestination($disk, $path)
                ->fromSource($m);

            // If the request has meta data about the file, apply that meta data as part of the upload.
            if ($data->isNotEmpty()) {
                $model->beforeSave(function (Media $m) use ($data) {
                    $m->fill($data->toArray());
                });
            }

            // Check that the file we're uploading doesn't already exist
            if ($c = $this->model::inDirectory($disk, $path)->where('filename', $m->getClientOriginalName())->count()) {
                $model = $model->useFilename("{$m->getClientOriginalName()}_{$c}");
            }

            $response[] = $model->upload();
        }

        // Return all the media.
        return response($response);
    }

    /**
     * Move or rename a specified media entry.
     *
     * @param  Request  $request
     * @return \Exception|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|MediaMoveException
     * @throws \Plank\MediaManager\Exceptions\MediaManagerException
     */
    public function update(MediaUpdateRequest $request)
    {
        $model = config('media-manager.model');
        $valid = $request->validated();

        $media = $model::find($valid['id']);
        $disk = $this->manager->verifyDisk($valid['disk']);
        $path = $this->manager->verifyDirectory($disk, $valid['path'] ?? $media->directory);

        if (!$request->has('path')) {
            $details = $request->only(['title', 'alt', 'caption', 'credit']);
            // Can't call fill due to backwards compatibility (fill doesn't trigger mutators)... Use loop instead.
            foreach ($details as $attribute => $detail) {
                $media->$attribute = $detail;
            }
        }

        if ($path != $media->directory) {
            $media->move($path, $valid['rename'] ?? null);
        }

        $media->save();
        return response($media->fresh());
    }

    /**
     * Delete the specified file from the disk, along with its entry in Media
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = config('media-manager.model');
        $id = $request->id;
        return response($model::destroy($id));
    }

    /**
     * Adjust the size of a specified piece of media, while preserving aspect ratio
     * Note: Does **not** preserve original image
     *
     * @param  Request  $request
     * @throws \Plank\MediaManager\Exceptions\MediaManagerException
     */
    public function resize(Request $request)
    {
        $model = config('media-manager.model');
        $id = $request->id;
        $size = $request->size;
        // TODO: add exceptions for this that will detect incorrect function calls
        $function = $request->function ?? MediaManager::RESIZE_WIDTH;

        $image = $model::findOrFail($id);
        $this->manager->resize($image, $size, $function);
    }
}
