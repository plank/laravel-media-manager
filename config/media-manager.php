<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'model' => \Plank\MediaManager\Models\Media::class,
    // The relative path to the conversions directory, **including** the trailing slash
    'conversions-directory' => "conversions/",
    'conversions' => [
        // 240 is the maximum image width, ie: 240w
        'thumb' => '240'
    ]
];
