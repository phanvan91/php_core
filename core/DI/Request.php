<?php

namespace Core\DI;

class Request implements RequestInterface
{
    public function all()
    {
        return [
            'test' => 123
        ];
    }
}