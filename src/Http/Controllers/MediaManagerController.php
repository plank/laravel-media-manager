<?php

namespace Plank\MediaManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Plank\MediaManager\Models\Media;
use Plank\MediaManager\Exceptions\MediaManagerException;
use Plank\MediaManager\MediaManager;

class MediaManagerController extends BaseController
{
    protected $manager;

    public function __construct(MediaManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Summon the view containing the media manager component
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('media-manager');
    }

    /**
     * Create a folder on disk with the given name
     * @param  Request  $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws MediaManagerException
     */
    public function create(Request $request)
    {
        $disk = $this->manager->verifyDisk($request->disk);
        $path = $request->path;

        if (Storage::disk($disk)->has($path)) {
            throw MediaManagerException::directoryAlreadyExists($disk, $path);
        }

        Storage::disk($disk)->makeDirectory($path);

        $key = explode('/', $path);
        array_pop($key);
        $key = trim("root." . implode('.', $key), "\.");
        // Invalidate the cache when a new folder is created.
        Cache::forget("media.manager.folders.{$key}");

        return response([
            'success' => true,
            'path'  =>  $path,
        ]);
    }

    /**
     * Move an entire directory, and it's contained media to another folder. Supports renaming folders as well.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws MediaManagerException
     */
    public function update(Request $request)
    {
        $disk = $this->manager->verifyDisk($request->disk);
        $source = $this->manager->verifyDirectory($disk, $request->source);
        $container = collect(explode('/', $source))->last();
        $destination = trim($request->destination, '/') . "/" . $container;

        $moved = Media::inOrUnderDirectory($disk, $source)->get()->each(function ($media) use ($destination) {
            $media->move($destination);
        });

        // only the files themselves were moved, so delete the remaining folder structure.
        Storage::disk($disk)->deleteDirectory($source);

        return response([
            'success' => true,
            'media' => $moved
        ]);
    }

    /**
     * Delete the specified folder from the disk, along with its entries in Media
     * @param  Request  $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws MediaManagerException
     */
    public function destroy(Request $request)
    {
        $disk = $this->manager->verifyDisk($request->disk);
        $path = $this->manager->verifyDirectory($disk, $request->path);
        $parent = collect(explode("/", $path))->slice(-1)->implode("/");

        Cache::forget("root.{$parent}");
        Cache::forget("root.{$path}");
        Storage::disk($disk)->deleteDirectory($path);
        Media::where('directory', $path)->delete();

        return response(["success" => true, 'parentFolder' => $parent]);
    }
}
