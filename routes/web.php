<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Garble\Http\Controllers\UserController;

Auth::routes();

/*
 * Indexes
 */
Route::get('/', 'HomeController@welcome')->name('welcome.index');
Route::middleware('auth')->get('/home', 'HomeController@index')->name('home.index');

/*
 * Models
 */
UserController::routes();

Route::middleware('texts')->group(function () {
    Route::resource('note', 'NoteController');
    Route::resource('post', 'PostController');
    Route::resource('todo', 'ToDoController');
});
