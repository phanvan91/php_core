<?php

namespace Core\Request;

use Core\Config;

class Request
{
    protected $method;

    public function __construct()
    {
        $this->method = Config::get('app.server_request_method');
    }

    public function all()
    {
        $data = [];
        switch ($this->method) {
            case 'GET':
                $data = $_GET;
                break;
            case 'POST':
                $data = array_merge($_POST, $_FILES);
                break;
        }

        return $data;
    }

    public function host()
    {
        return Config::get('app.server_http_host');
    }

    public function only(array $keys)
    {
        $data = $this->all();
        if(count($keys)) {
           foreach($data as $key => $value) {
               if(!in_array($key, $keys)) {
                   unset($data[$key]);
               }
           }
        }

        return $data;
    }
}