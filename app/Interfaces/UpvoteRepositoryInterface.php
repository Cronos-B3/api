<?php

namespace App\Interfaces;

interface UpvoteRepositoryInterface
{
    public function upvote($postId);
    public function undoUpvote($postId);
    public function getUpvotes($postId);
}
