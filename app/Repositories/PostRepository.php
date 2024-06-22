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
        return Post::withCount(['likes', 'upvotes'])->get();

    }

    public function getMyPosts()
    {
        $user = auth()->user();

        if (!$user) {
            throw AuthExceptions::UserNotConnected();
        }

        return $user->posts;
    }

    //soft get 
    // pp , username, timestamp, content, likes? , upVoted? , count like, count up vote,

    public function getById($postId)
    {
        $post = Post::withCount(['likes', 'upvotes'])->find($postId);

        if (!$post) {
            throw ObjectExcpetions::InvalidPost();
        }

        return $post;
    }

    public function getMyFeed()
    {
        // make algorithm to get posts by user
        return Post::all();
    }
    public function getFeedByUser($userId)
    {
        // make algorithm to get posts by user
        return Post::all();
    }

    public function store($data)
    {
        $user = auth()->user();

        if (!$user) {
            throw AuthExceptions::UserNotConnected();
        }

        return  $user->posts()->create($data);
    }

    // public function update(UpdatePostRequest $request,$postId)
    // {
    //     $post = Post::findOrFail($postId);
    //     return $post->update($request->validated());
    // }

    // public function delete($postId)
    // {
    //     $post = Post::findOrFail($postId);
    //     $post->delete();
    // }
}
