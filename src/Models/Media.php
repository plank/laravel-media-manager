<?php


namespace Plank\MediaManager\Models;

use Plank\Mediable\Media as BaseMedia;
use Plank\MediaManager\Concerns\Convertible;


class Media extends BaseMedia
{
    use Convertible;

    protected $appends = ['url', 'conversion_urls'];

    public function getUrlAttribute()
    {
        return $this->getUrl();
    }
}
