<?php

use Illuminate\Support\Facades\Route;

// =============================================================
// View Routes
// =============================================================

Route::group(['prefix' => 'media', 'as' => 'media.'], function () {
    Route::get('index', 'MediaManagerController@index')->name('index');
});

// =============================================================
// Json Routes
// =============================================================
Route::group(['prefix' => 'media-api', 'as' => 'media-api.'], function () {

    Route::post('create', 'MediaController@create')->name('create');
    Route::post('directory/create', 'MediaManagerController@create')->name('directory.create');
    Route::post('resize', 'MediaController@resize')->name('resize');
    Route::post('update', 'MediaController@update')->name('update');
    Route::post('directory/update', 'MediaManagerController@update')->name('directory.update');

    Route::post('destroy', 'MediaController@destroy')->name('destroy');
    Route::post('directory/destroy', 'MediaManagerController@destroy')->name('directory.destroy');

    Route::get('show/{id}', 'MediaController@show')->name('show');
    Route::get('index/{path}', 'MediaController@index')->name('index')
        ->where(['path' => '.*']);
});
