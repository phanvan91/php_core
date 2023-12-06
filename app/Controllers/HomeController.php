<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use Core\DI\Request;
use App\Repositories\UserRepositoryInterface;

class HomeController
{
    protected Request $request;

    protected UserRepository $userRepository;

//    public function __construct()
//    {
//    }

    public function index() //Request $request
    {
        var_dump($_SERVER);
        return view('users');
    }

    public function testPost()
    {
        $data = request()->only([
        ]);

        dd($data);
    }
}