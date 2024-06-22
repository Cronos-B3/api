<?php

namespace App\Interfaces;

interface FriendRepositoryInterface
{
    public function getMyFollows();
    public function getMyFollowers();
    public function follow($userId);
    public function unFollow($userId);
    public function getFollowsByUser($userId);
    public function getFollowersByUser($userId);
}
