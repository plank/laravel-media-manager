<?php

namespace Plank\MediaManager;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Plank\Mediable\Media;
use Plank\MediaManager\MediaManager as Manager;

trait Conversions
{
    protected $conversions = [];

    protected static function bootConversions()
    {
        static::save(function (Model $model) {
            $model->saveConvertions();
        });

        static::delete(function (Model $model) {

        });
    }

    public function saveConvertions(): void
    {
        $taggedMedia = $this->getMedia(array_keys($this->conversions));
        foreach ($taggedMedia as $media){
                $converted = Media::InDirectory($media->disk, 'Conversions/'.$media->directory)
                    ->where('filename',$this->getConversionName($media->filename, $media->tag))
                    ->first();
                if (!$converted){
                    $converted = $media->copyTo('Conversions/'.$media->directory,
                        $this->getConversionName($media->filename, $media->tag));
                }
                foreach($this->conversions[$media->tag] as $task=>$parameters){
                    MediaManager::{$task}($converted, ...$parameters);
                }
        }
    }

    public function getConversionName(string $filename, string $tag): string
    {
        //TODO::this is a comment: the conversions needs to be a mutator on the media model that is an associative
        // array that sees the tag and who's value is the path to the conversion
        //shamelessly stolen from MediaUploader
        $ctx = hash_init('md5');
        hash_update_file($ctx, $filename . '-' . get_class($this) . '-' . $tag);
        return hash_final($ctx);
    }

}
