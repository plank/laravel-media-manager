<?php
namespace Plank\MediaManager\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Plank\Mediable\MediaMover;
use Plank\MediaManager\Models\Media;
use Plank\MediaManager\Exceptions\MediaManagerException;
use Plank\MediaManager\MediaManager;

class MediaManagerController extends BaseController
{
    protected $manager;
    protected $mover;

    public function __construct(MediaManager $manager, MediaMover $mover)
    {
        $this->manager = $manager;
        $this->mover = $mover;
    }

    public function index()
    {
        return view('media-manager');
    }

    public function create(Request $request)
    {
        $disk = $this->manager->verifyDisk($request->disk);
        $path = $request->path;

        if (Storage::disk($disk)->has($path)) {
            throw MediaManagerException::directoryAlreadyExists($disk, $path);
        }

        return response(['success' => true]);
    }

    public function update(Request $request)
    {
//        $valid = $request->validate([
//            'source' => 'required|string',
//            'destination' => 'required|string',
//            'disk' => 'nullable'
//        ]);
        $source = $request->source;
        $destination = $request->destination;
        $disk = $request->disk;

        $container = collect(explode('/', $source))->last();
        $destination .= "/" . $container;

        $filesystem = Storage::disk($disk);
        if (!$filesystem->exists($destination)) {
            $filesystem->makeDirectory($destination);
        }

        $media = Media::whereDirectory($source)->get();
        $moved = collect();
        foreach ($media as $medium) {
            $this->mover->move($medium, $destination);
            $moved[] = $medium->fresh();
        }
        $filesystem->deleteDirectory($source);

        return response($moved);
    }

    public function destroy(Request $request)
    {
        $disk = $this->manager->verifyDisk($request->disk);
        $path = $this->manager->verifyDirectory($disk, $request->path);
        Storage::disk($disk)->deleteDirectory($path);
        Media::where('directory', $path)->delete();
        return response(["success" => true]);
    }
}
