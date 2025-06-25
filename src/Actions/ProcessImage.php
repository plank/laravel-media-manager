<?php


namespace Plank\MediaManager\Actions;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessImage
{
    public static function execute($media, $conversionWidth, $name, $disk = null)
    {
        $path = $media->getAbsolutePath();
        $filesystem = Storage::disk($disk);
        $destination = config('media-manager.conversions-directory');

        if (!$filesystem->exists($destination)) {
            $filesystem->makeDirectory($destination);
        }

        $destination = $filesystem->getDriver()->getAdapter()->getPathPrefix().$destination;

        $media = app('media-manager');
        if (strpos($media->mime_type, 'image') === 0) {
            $media->manager->make($path)
                ->resize($conversionWidth, null, function ($contraint) {
                    $contraint->aspectRatio();
                })
                ->save($destination.$name);
            // Clear stats cache since filesize() relies on stat cache
//            clearstatcache();
            $size = filesize($path);
            Log::info("Image Processed on {$path}::{$media->id}. New file size: {$size}.");
        } else {
            Log::info("Skipping Image Processing on {$path}. Not an image.");
        }
    }
}
