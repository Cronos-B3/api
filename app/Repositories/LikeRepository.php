<?php

namespace App\Repositories;

use App\Interfaces\LikeRepositoryInterface;

class LikeRepository implements LikeRepositoryInterface
{
    public function like($postId)
    {
        // Like post
    }

    public function unlike($postId)
    {
        // Unlike post
    }

    public function getLikes($postId)
    {
        // Get likes for post
    }
}
