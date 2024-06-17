<?php

namespace App\Repositories;

use App\Http\Requests\UpdatePostRequest;
use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{


    public function index()
    {
        return Post::all();
    }
    //soft get 
    // pp , username, timestamp, content, likes? , upVoted? , count like, count up vote,

    public function getById($postId)
    {
        return Post::findOrFail($postId);
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
