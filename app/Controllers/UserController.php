<?php

namespace App\Controllers;

use App\Services\UserService;
use Core\DI\Request;

class UserController
{
    protected $userService;
    protected $request;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->request = new Request();
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();

        echo json_encode($users);
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        echo json_encode($user);
    }

    public function store()
    {
        $data = $this->request->all();
        $user = $this->userService->createUser($data);
        return json_encode($user);
    }

    public function update($id)
    {
        $data = $this->request->all();
        $user = $this->userService->updateUser($id, $data);
        return json_encode($user);
    }

    public function destroy($id)
    {
        $result = $this->userService->deleteUser($id);
        return json_encode(['success' => $result]);
    }
} 