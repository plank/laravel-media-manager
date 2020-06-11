<?php

namespace Plank\MediaManager;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Plank\Mediable\Media;
use Plank\MediaManager\MediaManager as Manager;

trait Conversions
{
    protected $conversions = [];

    protected static function bootConversions(){
        static::save(function (Model $model) {
           //do things
        });

        static::delete(function (Model $model) {

        });
    }

    public function createConvertions()
    {
        $taggedMedia = $this->getMedia(array_keys($this->conversions));
        foreach ($taggedMedia as $media){
                $converted = Media::InDirectory($media->disk, 'Conversions/'.$media->directory)
                    ->where('filename',$media->filename.'-'.$media->tag)
                    ->first();
                if (!$converted){
                    $converted = $media->copyTo('Conversions/'.$media->directory, $media->filename.'-'.$media->tag);
                }
                foreach($this->conversions[$media->tag] as $task=>$parameters){
                    MediaManager::{$task}($converted, ...$parameters);
                }

        }
    }
}
