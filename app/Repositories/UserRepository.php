<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function index()
    {
        return User::all();
    }

    public function store($data)
    {
        return User::create($data);
    }

    public function getById($userId)
    {
        return User::findOrfail($userId);
    }

    public function update($data, $userId)
    {
        $user = User::findOrfail($userId);
        return $user->update($data);
    }

    public function delete($userId)
    {
        $user = User::findOrfail($userId);
        return $user->delete();
    }
}
