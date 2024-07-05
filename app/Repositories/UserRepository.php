<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function me()
    {
        $user = auth()->user();

        $user = $user->loadCount(['followers', 'follows']);

        return $user;
    }

    public function update($data)
    {
        $user = auth()->user();

        $user->update($data);

        return $user;
    }

    public function destroy()
    {
        $user = auth()->user();

        $user->delete();
    }


    public function getUserById($userId)
    {
        return User::find($userId);
    }
}
