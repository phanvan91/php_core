<?php

return [
    'server_document_root' => $_SERVER['DOCUMENT_ROOT'],
    'path_request_uri' => parse_url($_SERVER['REQUEST_URI'])['path'],
    'path_view' => $_SERVER['DOCUMENT_ROOT'] . '/views'
];