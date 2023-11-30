<?php
namespace App\Controllers;

use Core\DI\Request;

class HomeController
{
    private Request $request;

    public function index(Request $request) //Request $request
    {
//        dd($request->all());
        return view('users');
    }
}