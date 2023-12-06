<?php

use Core\Routes\Route;
use Core\DIContainer;
use Core\Config;
use App\Controllers\HomeController;

//$instance = DIContainer::instance();

//$class = $instance->make(HomeController::class);

//$instance->call(['HomeController', 'index']);
////
//$instance->call(['TestController', 'index']);

//$container = new DIContainer();



// setup router
require __DIR__.'/../routes/view.php';
require __DIR__.'/../routes/api.php';

$requestMethod = Config::get('app.server_request_method');
$requestUri = Config::get('app.server_request_uri_path');

$dispatcher = new Route($requestMethod, $requestUri);
$dispatcher->dispatch();