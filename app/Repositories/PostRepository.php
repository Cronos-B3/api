<?php

namespace App\Repositories;

use App\Exceptions\AuthExceptions;
use App\Exceptions\ObjectExcpetions;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use App\Models\User;

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
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getById($postId)
    {
        $user = auth()->user();

        if (!$user) {
            throw AuthExceptions::UserNotConnected();
        }

        $post = Post::find($postId);

        if (!$post) {
            throw ObjectExcpetions::InvalidPost();
        }

        $post->with(['user', 'userLiked', 'userUpvoted'])
            ->withCount(['likes', 'upvotes', 'comments']);

        return $post;
    }

    public function getByUserId($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw ObjectExcpetions::InvalidUser();
        }

        return $user->posts()->where('finished_at', '>', now())
            ->with(['user', 'userLiked', 'userUpvoted'])
            ->withCount(['likes', 'upvotes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->get();
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
            ->get();
    }

    public function destroyPost($postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            throw ObjectExcpetions::InvalidPost();
        }

        $post->delete();
    }
}
