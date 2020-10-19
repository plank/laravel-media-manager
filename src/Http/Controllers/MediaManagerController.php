<?php
namespace Plank\MediaManager\Http\Controllers;

use App\Exceptions\MediaManagerException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Plank\Mediable\Media;
use Plank\Mediable\MediaMover;
use Plank\Mediable\MediaUploader;
use Plank\MediaManager\MediaManager;

class MediaManagerController extends BaseController
{
    protected $manager;
    protected $mover;
    protected $uploader;

    public function __construct(MediaUploader $uploader, MediaMover $mover)
    {
        $this->manager = new MediaManager();
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
        Storage::disk($disk)->makeDirectory($path);

        return response(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $disk = $this->manager->verifyDisk($request->disk);
        $path = $this->manager->verifyDirectory($disk, $request->path);
        Storage::disk($disk)->deleteDirectory($path);
        Media::where('directory', $path)->delete();
        return response();
    }

    public function update(Request $request) {
        $disk = $this->manager->verifyDisk($request->disk);
        $sourcePath = $this->manager->verifyDirectory($disk, $request->path);
        $destinationPath = $this->manager->verifyDirectory($disk, $request->path);

        $media = Media::inOrUnderDirectory($sourcePath)->get();
        $media->map(function ($medium) use ($destinationPath){
            // TODO: dont't manually invoke save for every move, implement a moveMany()?
            // TODO: Create destination sub directories, since the move is recursive?
            $this->mover->move($medium, $destinationPath);
        });

    }
}
