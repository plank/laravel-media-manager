<?php
namespace Plank\MediaManager\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MediaManagerController extends BaseController
{

    public function index()
    {
        // summon the media manager view?
    }

    public function create()
    {
        // create directory
    }

    public function destroy()
    {
        // delete a directory (and all the contained files)
    }
}
