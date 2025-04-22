<?php

namespace App\Repositories;

class UserRepository
{
    protected $users = [
        ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.comxxx'],
        ['id' => 2, 'name' => 'Jane Doe', 'email' => 'jane@example.com']
    ];

    public function list()
    {
        return $this->users;
    }

    public function find($id)
    {
        foreach ($this->users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }

    public function create($data)
    {
        $newUser = [
            'id' => count($this->users) + 1,
            'name' => $data['name'] ?? '',
            'email' => $data['email'] ?? ''
        ];
        $this->users[] = $newUser;
        return $newUser;
    }

    public function update($id, $data)
    {
        foreach ($this->users as &$user) {
            if ($user['id'] == $id) {
                $user['name'] = $data['name'] ?? $user['name'];
                $user['email'] = $data['email'] ?? $user['email'];
                return $user;
            }
        }
        return null;
    }

    public function delete($id)
    {
        foreach ($this->users as $key => $user) {
            if ($user['id'] == $id) {
                unset($this->users[$key]);
                return true;
            }
        }
        return false;
    }
}