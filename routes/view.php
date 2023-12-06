<?php

use Core\Routes\Route;


Route::get('/', 'HomeController@index');

Route::get('/test', 'TestController@index');

Route::post('/test', 'HomeController@testPost');


Route::get('/users',function () {
    echo 'users';
});

