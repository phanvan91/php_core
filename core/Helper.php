<?php
use Core\Config;


if (!function_exists('dd')) {
    function dd($value)
    {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
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