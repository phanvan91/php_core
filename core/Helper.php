<?php

use Core\Config;
use Core\Request\Request;

if (!function_exists('dd')) {
    function dd($value)
    {
        var_dump($value);
        die();
    }
}

if (!function_exists('view')) {
    function view($path)
    {
        if ($path) {
            $path = str_replace(".", "/", $path);
            $pathView = Config::get('app.path_view') . '/' . $path . '.php';
            if (file_exists($pathView)) {
                include $pathView;
            }
        }

        return null;
    }
}

if (!function_exists('request')) {
    function request()
    {
        $request = new Request();

        return $request;
    }
}