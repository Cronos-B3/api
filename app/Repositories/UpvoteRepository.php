<?php

namespace App\Repositories;

use App\Exceptions\ObjectExcpetions;
use App\Interfaces\UpvoteRepositoryInterface;
use App\Models\Post;

class UpvoteRepository implements UpvoteRepositoryInterface
{
    public function upvote($postId)
    {
        $userId = auth()->id();

        $post = Post::find($postId);
        if (!$post) {
            throw ObjectExcpetions::InvalidPost();
        }

        $alreadyUpvoted = $post->upvotes()->where('user_id', $userId)->exists();

        if (!$alreadyUpvoted) {
            $post->upvotes()->create([
                'user_id' => auth()->id(),
            ]);
        }
    }

    public function undoUpvote($postId)
    {
        $userId = auth()->id();

        $post = Post::find($postId);
        if (!$post) {
            throw ObjectExcpetions::InvalidPost();
        }

        $alreadyUpvoted = $post->upvotes()->where('user_id', $userId)->exists();

        if ($alreadyUpvoted) {
            $post->upvotes()->where('user_id', auth()->id())->delete();
        }
    }

    public function getUpvotes($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            throw ObjectExcpetions::InvalidPost();
        }

        return $post->upvotes()->get();
    }
}
