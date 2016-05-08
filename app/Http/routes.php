<?php

Route::group(['middleware' => 'api'], function () {

});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/home', 'HomeController@index');

    Route::resource('note', 'NotesController');
    Route::resource('post', 'PostsController');
    Route::resource('todo', 'ToDosController');
});
