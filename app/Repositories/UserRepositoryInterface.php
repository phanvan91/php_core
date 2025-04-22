<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function list();
    public function find($id);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
}