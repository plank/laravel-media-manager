<?php

namespace Plank\MediaManager\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Plank\Mediable\Exceptions\MediaMoveException;
use Plank\MediaManager\Models\Media;
use Plank\Mediable\MediaUploader;
use Plank\MediaManager\MediaManager;

class MediaController extends BaseController
{
    protected $manager;

    protected $uploader;

    /**
     *
     * @var array $ignore Directories, of format "path/relative/to/disk/root" to be ignored for display in the media manager.
     */
    protected $ignore = ["conversions"];

    public function __construct(MediaUploader $uploader, array $ignore = [])
    {
        $this->manager = new MediaManager();
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
        $model = config('media-manager.model');
        return response($model::findOrFail($id));
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
    public function create(Request $request)
    {
        $media = is_array($request->file) ? $request->file : [$request->file] ;
        $data = collect($request->only(['title', 'alt', 'caption', 'credit']));
        $disk = $this->manager->verifyDisk($request->disk);
        $path = $this->manager->verifyDirectory($disk, trim($request->path, "/"));
        $response = [];
        foreach ($media as $index => $m) {
            $model = $this->uploader
                ->toDestination($disk, $path)
                ->fromSource($m);
                if ($data->isNotEmpty() &&
                    (is_array($data['title']) || is_array($data['alt']) || is_array($data['caption']) || is_array($data['credit']))) {
                    $model->beforeSave(function (Media $m) use ($data, $index) {
                        $details = $data->mapWithKeys(function ($entries, $field) use ($index) {
                            return [$field => $entries[$index] ?? null];
                        });
                        $m->fill($details->toArray());
                    });
                } elseif (count($media) == 1) {
                    $model->beforeSave(function (Media $m) use ($data, $index) {
                        $m->fill($data->toArray());
                    });
                }
            $response[] = $model->upload();
        }
        return response($response);
    }

    /**
     * Move or rename a specified media entry.
     *
     * @param  Request  $request
     * @return \Exception|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|MediaMoveException
     * @throws \Plank\MediaManager\Exceptions\MediaManagerException
     */
    public function update(Request $request)
    {
        $model = config('media-manager.model');
        $table = (new $model())->getTable();
        $valid = $request->validate([
            'id' => "required|exists:{$table}",
            'disk' => "string",
            'path' => "string|nullable",
            'rename' => "string|nullable",
        ]);


        $media = $model::find($valid['id']);
        $disk = $this->manager->verifyDisk($valid['disk']);
        $path = $this->manager->verifyDirectory($disk, $valid['path'] ?? $media->directory);
        $details = $request->only(['title', 'alt', 'caption', 'credit']);

        $media->fill($details);

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
