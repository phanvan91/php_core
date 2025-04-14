<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use Core\DI\Request;
use App\Repositories\UserRepositoryInterface;

class HomeController
{
    protected Request $request;

    protected UserRepository $userRepository;

    public function index()
    {
        return view('users');
    }
}