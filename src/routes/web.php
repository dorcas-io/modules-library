<?php

Route::group(['namespace' => 'Dorcas\ModulesLibrary\Http\Controllers', 'middleware' => ['web']], function() {
    Route::get('sales', 'ModulesLibraryController@index')->name('sales');
});


?>