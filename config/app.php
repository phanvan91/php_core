<?php
$documentRoot = $_SERVER['DOCUMENT_ROOT'] ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PWD'];

return [

    /*
    |--------------------------------------------------------------------------
    | server_document_root
    |--------------------------------------------------------------------------
    | example: '/mnt/c/projects/github/php/php_test'
    */

    'server_document_root' => $documentRoot,

    /*
    |--------------------------------------------------------------------------
    | server_request_uri_path
    |--------------------------------------------------------------------------
    | path: /user or /
    */

    'server_request_uri_path' => isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : null,

    /*
    |--------------------------------------------------------------------------
    | server_request_method
    |--------------------------------------------------------------------------
    | method: GET, POST
    */

    'server_request_method' => isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null,

    /*
    |--------------------------------------------------------------------------
    | server_request_method
    |--------------------------------------------------------------------------
    | example: http://127.0.0.1:8001
    */

    'server_http_host' => isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null,

    /*
    |--------------------------------------------------------------------------
    | path_view, controller_dir, public_dir
    |--------------------------------------------------------------------------
    | path dir source
    */

    'path_view' => $documentRoot . '/views',

    'controller_dir' => $documentRoot . '/app/Controllers',

    'public_dir' => $documentRoot . '/public',
];