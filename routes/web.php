<?php

use Garble\Http\Controllers\UserController;

Auth::routes();

/*
 * Indexes
 */
Route::get('/', ['as' => 'welcome.index', 'uses' => 'HomeController@welcome']);
Route::middleware('auth')->get('/home', ['as' => 'home.index', 'uses' => 'HomeController@index']);

/*
 * Models
 */
UserController::routes();

Route::middleware('texts')->group(function () {
    Route::resource('note', 'NoteController');
    Route::resource('post', 'PostController');
    Route::resource('todo', 'ToDoController');
});
