<?php

namespace Plank\MediaManager;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Plank\MediaManager\Skeleton\SkeletonClass
 */
class MediaManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'media-manager';
    }
}
