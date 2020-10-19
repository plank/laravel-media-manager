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

    public function getConversionName(string $id, string $tag): string
    {
        return "$id-$tag";
    }

    public function saveConversions(): void
    {
        $conversions = $this->getConversionsDirectory($this->disk);
        foreach ($this->conversions as $tag => $width) {
            $filename = $this->getConversionName($this->id, $tag);
            ProcessImage::execute($this, $width, $conversions.$filename);
        }
    }

    public function deleteConversions(): void
    {
        File::delete(File::glob($this->getConversionsDirectory($this->disk)."{$this->id}-*"));
    }

    public function getConversionsDirectory($disk)
    {
        return Storage::disk($disk)->getDriver()->getAdapter()->getPathPrefix().config('media-manager.conversions-directory');
    }

}
