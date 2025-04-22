<?php
use Core\Routes\Route;

// User routes
Route::get('/api/v1/users', 'UserController@index');
Route::get('/api/v1/users/{id}', 'UserController@show');
Route::post('/api/v1/users', 'UserController@store');
Route::put('/api/v1/users/{id}', 'UserController@update');
Route::delete('/api/v1/users/{id}', 'UserController@destroy');