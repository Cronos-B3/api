<?php

namespace App\Repositories;

use App\Exceptions\ObjectExcpetions;
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

    public function getUserById($userId)
    {
        $user = auth()->user();

        $otherUser = User::find($userId);

        if (!$user) {
            throw ObjectExcpetions::InvalidUser();
        }

        $otherUser->loadCount(['followers', 'follows']);
        $isFollowing = $user->isFollowing($otherUser->id);
        $otherUser->is_following = $isFollowing;

        return $otherUser;
    }

    public function store($data)
    {
        $user = User::create($data);

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
}
