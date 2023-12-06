<?php

namespace App\Controllers;

class Controller
{
    /**
     * @param $data
     * @param $message
     * @param $code
     * @return void
     */
    public function responseApi($data = null, $message = 'success', $code = 200): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}