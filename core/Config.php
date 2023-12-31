<?php

namespace Core;

class Config
{
    const PATH = '/config';

    public static function get($path = null)
    {
        if ($path) {
            $path = explode('.', $path);
            if (count($path) === 2) {
                $file = $path[0];
                $key = $path[1];
                $documentRoot = $_SERVER['DOCUMENT_ROOT'] ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PWD'];
                $pathFile = $documentRoot . self::PATH . '/' . $file . '.php';
                if (file_exists($pathFile)) {
                    $arrayFile = include $pathFile;
                    if (is_array($arrayFile) && count($arrayFile) && isset($arrayFile[$key])) {
                        return $arrayFile[$key];
                    }
                }
            }
        }

        return false;
    }
}