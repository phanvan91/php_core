<?php

use Core\Routes\Route;

Route::get('/test1','HomeController@testPost');
Route::post('/test1','HomeController@testPost');