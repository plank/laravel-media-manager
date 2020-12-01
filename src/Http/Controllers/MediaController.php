<?php

namespace Plank\MediaManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Plank\Mediable\Exceptions\MediaMoveException;
use Plank\MediaManager\Models\Media;
use Plank\Mediable\MediaMover;
use Plank\Mediable\MediaUploader;
use Plank\MediaManager\MediaManager;

class MediaController extends BaseController
{
    protected $manager;
    protected $mover;
    protected $uploader;
    protected $model;

    public function __construct(MediaUploader $uploader, MediaMover $mover)
    {
        $this->manager = new MediaManager();
        $this->mover = $mover;
        $this->uploader = $uploader;
    }

    /**
     * Retrieve details about a specific piece of media
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(Media::findOrFail($id));
    }

    /**
     * List all files and subdirectories contained within $path.
     *
     * @param  Request  $request
     * @param $path
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Plank\MediaManager\Exceptions\MediaManagerException
     */
    public function index(Request $request, $path)
    {
        $disk = $this->manager->verifyDisk($request->disk);
        $path = $this->manager->verifyDirectory($disk, $path);
        $page = $request->page;

        $media = Media::inDirectory($disk, $path)->get()->forPage($page, 20);
        $subdirectories = Storage::disk($disk)->directories($path);

        return response(['subdirectories' => $subdirectories, 'media' => $media]);
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
        $media = $request->media;
        $disk = $this->manager->verifyDisk($request->disk);
        $path = $this->manager->verifyDirectory($disk, $request->path);

        return response($this->uploader->toDestination($disk, $path)->fromSource($media)->upload());
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
        $valid = $request->validate([
            'id' => "required|exists:{$model}",
            'disk' => "string",
            'path' => "string|required",
            'rename' => "string|nullable"
        ]);

        $disk = $this->manager->verifyDisk($valid['disk']);
        $path = $this->manager->verifyDirectory($disk, $valid['path']);

        $media = Media::find($valid['id']);

        try {
            $this->mover->move($media, $path, $valid['rename']);
        } catch (MediaMoveException $e) {
            return $e;
        }

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
        $id = $request->id;
        return response(Media::destroy($id));
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
        $id = $request->id;
        $size = $request->size;
        // TODO: add exceptions for this that will detect incorrect function calls
        $function = $request->function ?? MediaManager::RESIZE_WIDTH;

        $image = Media::findOrFail($id);
        $this->manager->resize($image, $size, $function);
    }
}
