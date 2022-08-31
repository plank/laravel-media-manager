<?php

namespace Plank\MediaManager\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
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
        // Invalidate the cache when a new folder is created.
        $this->invalidateFolderCache($path);

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

        if ($source === $destination) {
            throw MediaManagerException::directoryAlreadyExists($disk, $destination);
        }

        $moved = collect();

        // get a list of directories that need to be created in the destination directory
        $directories = Storage::disk($disk)->allDirectories($source);
        $destinationDirectories = array_map(function ($directory) use ($source, $container, $destination) {
            return $destination . str_replace($source, '', $directory);
        }, $directories);
        array_unshift($destinationDirectories, $destination);

        // check if a directory with the same name as root already exists in the destination directory
        if (Storage::disk($disk)->has($destinationDirectories[0])) {
            throw MediaManagerException::directoryAlreadyExists($disk, $destinationDirectories[0]);
        }

        // create directories in the destination directory
        foreach ($destinationDirectories as $destinationDirectory) {
            Storage::disk($disk)->makeDirectory($destinationDirectory);
        }

        // get list of files that need to be moved
        $files = Media::where('disk', $disk)->where(function (Builder $q) use ($source) {
            $source = str_replace(['%', '_'], ['\%', '\_'], $source);
            $q->where('directory', $source);
            $q->orWhere('directory', 'like', $source . '/%');
        })->get();

        if ($files->count() > 0) {
            $files->each(function ($media) use ($disk, $source, $destination, $moved) {
                $directory = trim(str_replace($source, $destination, $media->directory), '/');
                $media->move($directory);
                $moved[] = $media->fresh();
            });
        }

        Storage::disk($disk)->deleteDirectory($source);
        $this->invalidateFolderCache($source);
        $this->invalidateFolderCache($destination);

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

        Storage::disk($disk)->deleteDirectory($path);
        Media::where('disk', $disk)->where(function (Builder $q) use ($path) {
            $path = str_replace(['%', '_'], ['\%', '\_'], $path);
            $q->where('directory', $path);
            $q->orWhere('directory', 'like', $path . '/%');
        })->delete();
        $this->invalidateFolderCache($path);

        return response(["success" => true, 'parentFolder' => $parent]);
    }

    private function invalidateFolderCache($path)
    {
        $key = explode('/', $path);
        array_pop($key);
        $key = trim("root." . implode('.', $key), "\.");

        Cache::forget("media.manager.folders.{$key}");
    }
}
