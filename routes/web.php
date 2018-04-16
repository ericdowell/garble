<?php

Auth::routes();

/*
 * Indexes
 */
Route::get('/', ['as' => 'welcome.index', 'uses' => 'WelcomeController@index']);
Route::get('/home', ['as' => 'home.index', 'uses' => 'HomeController@index']);
/*
 * Models
 */
Route::middleware('texts')->group(function () {
    Route::resource('note', 'NotesController');
    Route::resource('post', 'PostsController');
    Route::resource('todo', 'ToDosController');
});
