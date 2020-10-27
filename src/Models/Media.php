<?php


namespace Plank\MediaManager\Models;

use Plank\Mediable\Media as BaseMedia;
use Plank\MediaManager\Concerns\Convertible;


class Media extends BaseMedia
{
    use Convertible;
}
