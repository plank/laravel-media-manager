<?php

namespace Plank\MediaManager\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
        $this->conversions = collect(config("media-manager.conversions"))->sortKeys();
    }

    public function getConversionName(string $tag): string
    {
        return "{$this->id}-{$tag}.{$this->extension}";
    }

    public function getConversion($tag, $disk = null)
    {
        return Storage::disk($disk)->url(config('media-manager.conversions-directory').$this->getConversionName($tag));
    }

    public function getConversions($disk = null)
    {
        return collect(File::glob($this->getConversionsDirectory($disk)."{$this->id}-*"))->mapWithKeys(function ($path, $count) use ($disk) {
            $parts = explode('/', $path);
            $tags = $this->conversions->keys();
            return [$tags[$count] => Storage::disk($disk)->url(config('media-manager.conversions-directory').end($parts))];
        });
    }

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
