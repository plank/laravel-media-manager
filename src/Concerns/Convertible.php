<?php

namespace Plank\MediaManager\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Plank\Mediable\Media;
use Plank\MediaManager\Actions\ProcessImage;
use Plank\MediaManager\MediaManager;

trait Convertible
{
    protected $conversions = [];

    protected static function bootConvertible()
    {
        static::saved(function (Model $model) {
            $model->saveConversions();
        });

        static::deleted(function (Model $model) {
            $model->deleteConversions();
        });
    }

    protected function initializeConvertible()
    {
        $this->conversions = config("media-manager.conversions");
    }

    public function getConversionName(string $tag): string
    {
        return "{$this->id}-{$tag}.{$this->extension}";
    }

//    public function getConversion($tag, $disk = null)
//    {
//        return Storage::get($this->getConversionsDirectory($disk).$this->getConversionName($tag));
//    }

    public function saveConversions(): void
    {
        foreach ($this->conversions as $tag => $width) {
            $filename = $this->getConversionName($tag);
            ProcessImage::execute($this, $width, $filename, $this->disk);
        }
    }

    public function deleteConversions(): void
    {
        File::delete(File::glob($this->getConversionsDirectory($this->disk)."{$this->id}-*"));
    }

    public function getConversionsDirectory($disk = null)
    {
        return Storage::disk($disk)->getDriver()->getAdapter()->getPathPrefix().config('media-manager.conversions-directory');
    }

}
