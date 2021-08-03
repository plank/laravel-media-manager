<?php

use Illuminate\Support\Facades\Route;


// =============================================================
// View Routes
// =============================================================

Route::group(['prefix' => 'media', 'as' => 'media.', 'namespace' => 'Plank\MediaManager\Http\Controllers'], function () {
    Route::get('index', 'MediaManagerController@index')->name('index');
});

// =============================================================
// Json Routes
// =============================================================
Route::group(['prefix' => 'media-api', 'as' => 'media-api.', 'namespace' => 'Plank\MediaManager\Http\Controllers'], function () {

    Route::post('create', 'MediaController@create')->name('create');
    Route::post('directory/create', 'MediaManagerController@create')->name('directory.create');
    Route::post('resize', 'MediaController@resize')->name('resize');
    Route::post('update', 'MediaController@update')->name('update');
    Route::post('directory/update', 'MediaManagerController@update')->name('directory.update');

    Route::post('destroy', 'MediaController@destroy')->name('destroy');
    Route::post('directory/destroy', 'MediaManagerController@destroy')->name('directory.destroy');

    Route::get('show/{id}', 'MediaController@show')->name('show');
    Route::get('/search', 'MediaSearchController@index')->name('search.index');
    Route::get('index/{path?}', 'MediaController@index')->name('index')
        ->where(['path' => '.*']);

    Route::get('settings', 'MediaController@index')->name('settings.index');
});
