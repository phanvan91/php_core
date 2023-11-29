<?php
$documentRoot = $_SERVER['DOCUMENT_ROOT'] ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['PWD'];

return [
    'server_document_root' => $documentRoot,

    'path_request_uri' => isset($_SERVER['REQUEST_URI']) ?  parse_url($_SERVER['REQUEST_URI'])['path'] : null,

    'path_view' => $documentRoot . '/views',

    'controller_dir' => $documentRoot . '/app/Controllers',

    'public_dir' => $documentRoot . '/public',
];