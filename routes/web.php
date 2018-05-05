<?php

Auth::routes();

/*
 * Indexes
 */
Route::get('/', ['as' => 'welcome.index', 'uses' => 'HomeController@welcome']);
Route::middleware('auth')->get('/home', ['as' => 'home.index', 'uses' => 'HomeController@index']);

/*
 * Models
 */
Route::get('user/password/{user}/edit', ['as' => 'user.password-edit', 'uses' => 'UserController@passwordEdit']);
Route::patch('user/password/{user}', ['as' => 'user.password-update', 'uses' => 'UserController@passwordUpdate']);
Route::resource('user', 'UserController');

Route::middleware('texts')->group(function () {
    Route::resource('note', 'NoteController');
    Route::resource('post', 'PostController');
    Route::resource('todo', 'ToDoController');
});
