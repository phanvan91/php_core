<?php

namespace Core\Routes;

class Route
{
    public static $routes = array();

    private $requestMethod;

    private $requestUri;

    public function __construct($requestMethod, $requestUri)
    {
        $this->requestMethod = $requestMethod;
        $this->requestUri = $requestUri;
    }

    public static function addRoute($method, $route, $action)
    {
        self::$routes[$method][$route] = $action;
    }

    public static function get($route, $action)
    {
        self::addRoute('GET', $route, $action);
    }

    public static function post($route, $action)
    {
        self::addRoute('POST', $route, $action);
    }

    public function dispatch()
    {
        foreach (self::$routes[$this->requestMethod] as $route => $action) {
            if ($route === $this->requestUri) {
                return $this->executeAction($action);
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }

    private function executeAction($action)
    {
        if (is_callable($action)) {
            return $action();
        }
        list($controller, $method) = explode('@', $action);
        $controller = "App\\Controllers\\". $controller;

        $controller = new $controller;
        return $controller->$method();
    }
}