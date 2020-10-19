<?php


namespace Plank\MediaManager\Actions;


use Illuminate\Support\Facades\Log;
use Intervention\Image\Image;
use Plank\Mediable\Media;

class ProcessImage
{
    public static function execute($media, $conversionWidth, $destination)
    {
        $path = $media->getAbsolutePath();
        if (strpos($media->mime_type, 'image') === 0) {
            Image::make($path)
                ->resize($conversionWidth, null, function ($contraint) {
                    $contraint->aspectRatio();
            })
                ->save($destination);
            // Clear stats cache since filesize() relies on stat cache
//            clearstatcache();
            $size = filesize($path);
            Log::info("Image Processed on {$path}::{$media->id}. New file size: {$size}.");
        } else {
            Log::info("Skipping Image Processing on {$path}. Not an image.");
        }
    }
}
