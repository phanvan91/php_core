<?php
use Core\Config;


if (!function_exists('dd')) {
    function dd($value)
    {
        if(gettype($value) === 'object') {
            print_r($value);
            $class_methods = get_class_methods(new $value());
            foreach ($class_methods as $method_name)
            {
                echo "$method_name<br/>";
            }
        }else {
            echo "<pre>";
            var_dump($value);
            echo "</pre>";
        }



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