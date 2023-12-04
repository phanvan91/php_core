<?php
$documentRoot = $_SERVER['DOCUMENT_ROOT'] ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PWD'];

return [
    'server_document_root' => $documentRoot,

    'server_request_uri_path' => isset($_SERVER['REQUEST_URI']) ?  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : null,

    'server_request_method' => isset($_SERVER['REQUEST_METHOD']) ?  $_SERVER['REQUEST_METHOD'] : null,

    'path_view' => $documentRoot . '/views',

    'controller_dir' => $documentRoot . '/app/Controllers',

    'public_dir' => $documentRoot . '/public',
];