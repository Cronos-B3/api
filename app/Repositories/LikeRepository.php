<?php

namespace App\Repositories;

use App\Exceptions\ObjectExcpetions;
use App\Interfaces\LikeRepositoryInterface;
use App\Models\Post;

class LikeRepository implements LikeRepositoryInterface
{
    public function like($postId)
    {
        $userId = auth()->id();

        $post = Post::find($postId);
        if (!$post) {
            throw ObjectExcpetions::InvalidPost();
        }

        $alreadyLiked = $post->likes()->where('user_id', $userId)->exists();

        if (!$alreadyLiked) {
            $post->likes()->create([
                "user_id" => auth()->id(),
            ]);
        }
    }

    public function unlike($postId)
    {
        $userId = auth()->id();

        $post = Post::find($postId);
        if (!$post) {
            throw ObjectExcpetions::InvalidPost();
        }

        $alreadyLiked = $post->likes()->where('user_id', $userId)->exists();

        if ($alreadyLiked) {
            $post->likes()->where("user_id", auth()->id())->delete();
        }
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
