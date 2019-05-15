<?php

Route::group(['namespace' => 'Dorcas\ModulesLibrary\Http\Controllers', 'middleware' => ['web','auth'], 'prefix' => 'mli'], function() {
    Route::get('library-main', 'ModulesLibraryController@main')->name('library-main');
    Route::get('library-videos', 'ModulesLibraryController@videos')->name('library-videos');
});


?>