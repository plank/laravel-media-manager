<?php

namespace Plank\MediaManager\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Plank\Mediable\Exceptions\MediaMoveException;
use Plank\Mediable\Media;
use Plank\Mediable\MediaMover;
use Plank\Mediable\MediaUploader;
use Plank\MediaManager\Conversions;
use Plank\MediaManager\MediaManager;


class MediaController extends BaseController
{
    protected $manager;
    protected $mover;
    protected $uploader;

    public function __construct(MediaUploader $uploader, MediaMover $mover)
    {
        $this->manager = new MediaManager();
        $this->mover = $mover;
        $this->uploader = $uploader;
    }

    public function show($id)
    {
        return response(Media::findOrFail($id));
    }

    public function index($path = '', $disk = '')
    {
        $disk = $this->manager->verifyDisk($disk);
        $path = $this->manager->verifyDirectory($disk, $path);

        $media = Media::inDirectory($disk, $path)->get();
        $subdirectories = Storage::disk($disk)->directories($path);

        return response(['subdirectories' => $subdirectories, 'media' => $media]);
    }

    public function create(Request $request)
    {
        // TODO: better validation, overall
        $media = $request->media;
        $disk = $this->manager->verifyDisk($request->disk);
        $path = $this->manager->verifyDirectory($disk, $request->path);


        return response($this->uploader->toDestination($disk, $path)->fromSource($media)->upload());
    }

    public function update(Request $request)
    {
        // TODO: Make this handle multiple update actions? Move, Rename, resize, crop?
        $id = $request->id;
        $disk = $this->manager->verifyDisk($request->disk);
        $path = $this->manager->verifyDirectory($disk, $request->path);

        $media = Media::with('models')->findOrFail($id);
        $conversions = collect();
        foreach ($media->models as $model) {
            if (in_array(Conversions::class, class_uses(get_class($model)))) {
                $conversions = $conversions->push($model->getConversionName($media->filename, $model->pivot->tag));
            }
        }
        $children = Media::inDirectory($media->disk, 'Conversions/' . $media->directory)
            ->whereIn('filename', $conversions)->get();
        try {
            $this->mover->move($media, $path);
            foreach ($children as $child) {
                $this->mover->move($child, 'Conversions/' . $path);
            }
        } catch (MediaMoveException $e) {
            return $e;
        }

        return response($media->fresh());
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        return response(Media::destroy($id));
    }

    public function resize(Request $request)
    {
        $id = $request->id;
        $size = $request->size;
        $disk = $request->disk;
        // TODO: add exceptions for this that will detect incorrect function calls
        $function = $request->function ?? MediaManager::RESIZE_WIDTH;

        $image = Media::findOrFail($id);
        $this->manager->resize($image, $size, $disk, $function);
    }
}
