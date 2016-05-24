<?php

Route::group(['middleware' => 'api'], function () {

});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    /*
     * Indexes
     */
    Route::get('/', ['as' => 'welcome.index', 'uses' => 'HomeController@welcome']);
    Route::get('/home', ['as' => 'home.index', 'uses' => 'HomeController@index']);
    /*
     * Models
     */
    Route::group(['middleware' => 'texts'], function () {
        Route::resource('note', 'NotesController');
        Route::resource('post', 'PostsController');
        Route::resource('todo', 'ToDosController');
    });
});
