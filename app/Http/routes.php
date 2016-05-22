<?php

Route::group(['middleware' => 'api'], function () {

});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    /**
     * Indexes
     */
    Route::get('/', ['as' => 'welcome.index', 'use' => 'HomeController@welcome']);
    Route::get('/home', ['as' => 'home.index', 'use' => 'HomeController@index']);
    /**
     * Models
     */
    Route::resource('note', 'NotesController');
    Route::resource('post', 'PostsController');
    Route::resource('todo', 'ToDosController');
});
