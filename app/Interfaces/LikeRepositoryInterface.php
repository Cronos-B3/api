<?php

namespace App\Interfaces;

interface LikeRepositoryInterface
{
    public function like($postId);
    public function unlike($postId);
    public function getLikes($postId);
}
