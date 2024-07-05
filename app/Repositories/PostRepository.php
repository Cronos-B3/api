<?php

namespace App\Repositories;

use App\Exceptions\AuthExceptions;
use App\Exceptions\ObjectExcpetions;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    public function index()
    {
        return Post::where('finished_at', '>', now())
            ->with(['user', 'userLiked', 'userUpvoted'])
            ->withCount(['likes', 'upvotes', 'comments'])
            ->get();
    }

    public function getMyPosts()
    {
        $user = auth()->user();

        $user->posts()->where('finished_at', '<', now())->delete();

        return  $user->posts()->with(['user', 'userLiked', 'userUpvoted'])
            ->withCount(['likes', 'upvotes', 'comments'])
            ->paginate(10);
    }

    public function getById($postId)
    {
        $user = auth()->user();

        if (!$user) {
            throw AuthExceptions::UserNotConnected();
        }

        $post = $user->posts->find($postId)
            ->with(['user', 'userLiked', 'userUpvoted'])
            ->withCount(['likes', 'upvotes', 'comments'])
            ->first();

        if (!$post) {
            throw ObjectExcpetions::InvalidPost();
        }

        return $post;
    }

    public function store($data)
    {
        $user = auth()->user();

        return $user->posts()->create($data)->load(['user', 'userLiked', 'userUpvoted'])
        ->loadCount(['likes', 'upvotes', 'comments']);
    }

    public function storeComment($data, $postId)
    {
        $user = auth()->user();

        if (!$user) {
            throw AuthExceptions::UserNotConnected();
        }

        $parentPost = Post::find($postId);

        if (!$parentPost) {
            throw ObjectExcpetions::InvalidPost();
        }

        $data['parent_id'] = (int)$postId;
        $data['finished_at'] = $parentPost->finished_at;

        return $user->posts()->create($data)->load(['user', 'userLiked', 'userUpvoted'])
            ->loadCount(['likes', 'upvotes', 'comments']);
    }

    public function getComments($postId)
    {
        $user = auth()->user();

        if (!$user) {
            throw AuthExceptions::UserNotConnected();
        }

        $parentPost = Post::find($postId);

        if (!$parentPost) {
            throw ObjectExcpetions::InvalidPost();
        }

        return $parentPost->comments()->with(['user', 'userLiked', 'userUpvoted'])
            ->withCount(['likes', 'upvotes', 'comments'])
            ->OrderBy('likes_count', 'desc')
            ->paginate(10);
    }
}
