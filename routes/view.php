<?php

use Core\Routes\Route;


Route::get('/', 'HomeController@index');

Route::get('/users',function () {
    echo 'users';
});

