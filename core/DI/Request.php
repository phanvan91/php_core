<?php

namespace Core\DI;

class Request implements RequestInterface
{
    public function all()
    {
        $data = [];
        
        // Get POST data
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
            $data = $_POST;
            
            // For PUT requests, we need to parse the input
            if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                parse_str(file_get_contents('php://input'), $putData);
                $data = array_merge($data, $putData);
            }
        }
        
        // Get GET data
        $data = array_merge($data, $_GET);
        
        return $data;
    }
}