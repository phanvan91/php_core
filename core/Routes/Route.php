<?php

namespace Core\Routes;

use Core\DIContainer;

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

    public static function put($route, $action)
    {
        self::addRoute('PUT', $route, $action);
    }

    public static function delete($route, $action)
    {
        self::addRoute('DELETE', $route, $action);
    }

    public function dispatch()
    {
        foreach (self::$routes[$this->requestMethod] as $route => $action) {
            // Convert route pattern to regex
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route);
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = '/^' . $pattern . '$/';

            if (preg_match($pattern, $this->requestUri, $matches)) {
                // Remove numeric keys from matches
                $params = array_filter($matches, function($key) {
                    return !is_numeric($key);
                }, ARRAY_FILTER_USE_KEY);

                return $this->executeAction($action, $params);
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }

    private function executeAction($action, $params = [])
    {
        if (is_callable($action)) {
            return $action(...$params);
        }
        list($controller, $method) = explode('@', $action);
        $controller = "App\\Controllers\\". $controller;

        // Use DI Container to create controller instance
        $container = DIContainer::instance();
        $controller = $container->make($controller);
        
        return $controller->$method(...$params);
    }
}