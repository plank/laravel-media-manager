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
        $query = $request->q;

        return Media::where('filename', 'like', "%{$query}%")
            ->orWhere('title', 'like', "%{$query}%")
            ->orWhere('caption', 'like', "%{$query}%")
            ->orWhere('alt', 'like', "%{$query}%")
            ->orWhere('credit', 'like', "%{$query}%")
            ->get();
    }
}
