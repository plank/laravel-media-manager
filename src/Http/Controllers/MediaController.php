<?php
namespace Plank\MediaManager\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Plank\Mediable\Media;
use Plank\Mediable\MediaUploader;
use Plank\MediaManager\MediaManager;

class MediaController extends BaseController
{
    protected $manager;
    protected $uploader;

    public function __construct(MediaUploader $uploader)
    {
        $this->manager = new MediaManager();
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

        return response(Media::inDirectory($disk, $path)->get());
    }

    public function create(Request $request)
    {
        // upload a file
    }

    public function update()
    {
        // move a file
    }

    public function destroy()
    {
        // delete a file
    }

    public function resize()
    {
        // resize a file
    }
}
