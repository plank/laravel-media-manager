<?php
namespace Plank\MediaManager\Http\Controllers;

use App\Exceptions\MediaManagerException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Plank\Mediable\Media;
use Plank\MediaManager\MediaManager;

class MediaManagerController extends BaseController
{
    protected $manager;

    public function __construct(MediaManager $manager)
    {
        $this->manager = $manager;
    }

    public function index()
    {
        return view('media-manager');
    }

    public function create()
    {
        $disk = $this->manager->verifyDisk($this->request->get('disk'));
        $path = $this->manager->verifyDirectory($disk, $this->request->path);

        if (Storage::disk($disk)->has($path)) {
            throw MediaManagerException::directoryAlreadyExists($disk, $path);
        }
        Storage::disk($disk)->makeDirectory($path);

        return response();
    }

    public function destroy()
    {
        $disk = $this->manager->verifyDisk($this->request->get('disk'));
        $path = $this->manager->verifyDirectory($disk, $this->path);
        Storage::disk($disk)->deleteDirectory($path);
        Media::where('directory', $path)->delete();
        return response();
    }
}
