<?php
/*
 * Configuration to allow for controlling or extending some default values of the media manager
 */
return [
    'model' => \Plank\MediaManager\Models\Media::class,
    'table' => env('MEDIA_TABLE', 'media'),
    // The relative path to the conversions directory, **including** the trailing slash
    'conversions-directory' => "conversions/",
    'conversions' => [
        // 240 is the maximum image width, ie: 240w
        'thumb' => '240'
    ]
];
