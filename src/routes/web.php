<?php

Route::group(['namespace' => 'Dorcas\ModulesLibrary\Http\Controllers', 'middleware' => ['web'], 'prefix' => 'mda'], function() {
    //Route::get('library-main', 'ModulesLibraryController@main')->name('library-main');
    //Route::get('library-videos', 'ModulesLibraryController@videos')->name('library-videos');

    Route::get('library-main', 'ModulesLibraryVideosController@index')->name('library-main');
    Route::get('library-videos', 'ModulesLibraryVideosController@index')->name('library-videos');
});


?>