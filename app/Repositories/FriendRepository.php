<?php

namespace App\Repositories;

use App\Exceptions\ObjectExcpetions;
use App\Interfaces\FriendRepositoryInterface;
use App\Models\User;

class FriendRepository implements FriendRepositoryInterface
{

    public function getMyFollows()
    {
        return auth()->user()->follows;
    }

    public function getMyFollowers()
    {
        return auth()->user()->followers;
    }

    public function follow($userId)
    {
        $user = auth()->user();

        if ($user->id == $userId) {
            throw ObjectExcpetions::InvalidUser();
        }

        if (!$user->isFollowing($userId)) {
            $user->follows()->attach($userId);
        }
    }

    public function unFollow($userId)
    {
        $user = auth()->user();

        if ($user->id == $userId) {
            throw ObjectExcpetions::InvalidUser();
        }

        $user->follows()->detach($userId);
    }

    public function getFollowsByUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw ObjectExcpetions::InvalidUser();
        }
        return $user->follows;
    }

    public function getFollowersByUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw ObjectExcpetions::InvalidUser();
        }

        return $user->followers;
    }
}
