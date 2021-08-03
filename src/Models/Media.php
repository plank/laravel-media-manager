<?php


namespace Plank\MediaManager\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Plank\Mediable\Media as BaseMedia;
use Plank\MediaManager\Concerns\Convertible;

/**
 * Class Media
 * @package Plank\MediaManager\Models
 * @property int|string $id
 * @property string $title
 * @property string $caption
 * @property string $alt
 * @property string $credit
 * @property string $source
 * @property string $disk
 * @property string $directory
 * @property string $filename
 * @property string $extension
 * @property string $basename
 * @property string $mime_type
 * @property string $aggregate_type
 * @property int $size
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Pivot $pivot
 * @property string $url
 * @property array $conversion_urls
 * @method string getConversionName(string $tag)
 * @method string getConversion(string $tag, string $disk = null)
 * @method array getConversions($diskName = null)
 * @method void saveConversions()
 * @method void deleteConversions()
 * @method string getConversionsDirectory($disk = null)
 *
 * @see \Plank\Mediable\Media
 * @see Convertible
 */
class Media extends BaseMedia
{
    use Convertible;

    protected $appends = ['conversion_urls', 'url'];

    public function getUrlAttribute()
    {
        return $this->getUrl();
    }
}
