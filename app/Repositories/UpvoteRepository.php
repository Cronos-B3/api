<?php

namespace App\Repositories;

use App\Interfaces\UpvoteRepositoryInterface;

class UpvoteRepository implements UpvoteRepositoryInterface
{
    public function upvote($postId)
    {
        // Upvote post
    }

    public function undoUpvote($postId)
    {
        // Undo upvote post
    }

    public function getUpvotes($postId)
    {
        // Get upvotes for post
    }
}
