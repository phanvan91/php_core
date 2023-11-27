<?php
$pathRequestURI = Config::get('app.path_request_uri');
$viewDir = 'views/';
include './app/controllers/HomeController.php';

switch ($pathRequestURI) {
    case '':
    case '/':
        require $viewDir . 'home.php';
        break;

    case '/users':
        require HomeController::index();
        break;

    case '/contact':
        require $viewDir . 'contact.php';
        break;

    default:
        http_response_code(404);
        require $viewDir . 'errors/' . '404.php';
}