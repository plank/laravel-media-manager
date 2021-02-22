<?php

namespace Plank\MediaManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
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
        return response([
            'success' => true,
            'path'  =>  $path,
        ]);
    }

    /**
     * Move an entire directory, and it's contained media to another folder. Supports renaming folders as well.
     *
     * Note: An edge case bug exists where if you move a folder from the root, which contains folders with the
     * containing folder's name as substrings for those folders, the action of moving will also rename those subfolders
     * resulting faulty move results
     * @param  Request  $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws MediaManagerException
     */
    public function update(Request $request)
    {
        $disk = $this->manager->verifyDisk($request->disk);
        $source = $this->manager->verifyDirectory($disk, $request->source);
        $destination = trim($request->destination, '/');
        $container = collect(explode('/', $source))->last();
        $rename = $request->rename ?? $container;
        $destination .= "/" . $rename;
        $filesystem = Storage::disk($disk);

        $filesystem->move($source, $destination);
        $moved = collect();
        Media::inOrUnderDirectory($disk, $source)->get()->each(function ($media) use ($source, $destination, $moved) {
            $media->directory = trim(str_replace($source, $destination, $media->directory), '/');
            $media->save();
            $moved[] = $media->fresh();
        });

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
        $string = $request->path;
        $string = substr($string, 0, strrpos($string, "/"));
        Storage::disk($disk)->deleteDirectory($path);
        Media::where('directory', $path)->delete();
        return response(["success" => true, 'parentFolder' => $string]);
    }
}
