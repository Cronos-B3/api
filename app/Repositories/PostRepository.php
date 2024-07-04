<?php

namespace App\Repositories;

use App\Exceptions\AuthExceptions;
use App\Exceptions\ObjectExcpetions;
use App\Http\Resources\GetMyPostCompleteResource;
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

        if (!$user) {
            throw AuthExceptions::UserNotConnected();
        }

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

        $post = $user->posts->find($postId);

        if (!$post) {
            throw ObjectExcpetions::InvalidPost();
        }

        return $post;
    }

    public function store($data)
    {
        $user = auth()->user();

        if (!$user) {
            throw AuthExceptions::UserNotConnected();
        }

        return  $user->posts()->create($data);
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


        return  $user->posts()->create($data);
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

        return $parentPost->comments()->get();
    }
}
