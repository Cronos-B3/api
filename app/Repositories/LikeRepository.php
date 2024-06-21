<?php

namespace App\Repositories;

use App\Exceptions\ObjectExcpetions;
use App\Interfaces\LikeRepositoryInterface;
use App\Models\Post;

class LikeRepository implements LikeRepositoryInterface
{
    public function like($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            throw ObjectExcpetions::InvalidPost();
        }

        $post->likes()->create([
            'user_id' => auth()->id(),
        ]);
    }

    public function unlike($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            throw ObjectExcpetions::InvalidPost();
        }

        $post->likes()->where('user_id', auth()->id())->delete();
    }

    public function getLikes($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            throw ObjectExcpetions::InvalidPost();
        }

        return $post->likes()->get();
    }
}
