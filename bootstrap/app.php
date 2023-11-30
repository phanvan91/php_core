<?php

use Core\Routes\Route;

use Core\DIContainer;
use Core\DI\Request;


$container = new DIContainer();

$container->addService('Request', new Request());


// setup router
require __DIR__.'/../routes/view.php';
require __DIR__.'/../routes/api.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$dispatcher = new Route($requestMethod, $requestUri);
$dispatcher->dispatch();



//$logger = $container->getService('Request');
//dd($logger->all());