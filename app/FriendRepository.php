<?php

namespace App\Repositories;

use App\Interfaces\FriendRepositoryInterface;

class FriendRepository implements FriendRepositoryInterface
{
  
    public function getMyFollows()
    {
        // get all follows of user
    }

    public function getMyFollowers()
    {
        // get all followers of user
    }

    public function follow($userId)
    {
        // follow user
    }

    public function unFollow($userId)
    {
        // unfollow user
    }

    public function getFollowsByUser($userId)
    {
        // get all follows of user
    }

    public function getFollowersByUser($userId)
    {
        // get all followers of user
    }
}
