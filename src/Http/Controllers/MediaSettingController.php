<?php
namespace Plank\MediaManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Plank\MediaManager\Models\Media;
use Plank\MediaManager\Exceptions\MediaManagerException;
use Plank\MediaManager\MediaManager;

class MediaSearchController extends BaseController
{
    protected $manager;

    public function __construct(MediaManager $manager)
    {
        $this->manager = $manager;
    }

    public function index(Request $request)
    {
        // TODO: filter sensitive items from array
        return array_merge(config('mediable'), config('media-manager'));
    }
}
