<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getAllUsers()
    {
        // TODO: Đặt breakpoint ở đây để debug
        return $this->userRepository->list();
    }

    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

    public function createUser($data)
    {
        // Validate data
        // Process data if needed
        return $this->userRepository->create($data);
    }

    public function updateUser($id, $data)
    {
        // Validate data
        // Process data if needed
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }
} 