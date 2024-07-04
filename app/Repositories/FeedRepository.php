<?php

namespace App\Repositories;

use App\Exceptions\AuthExceptions;
use App\Exceptions\ObjectExcpetions;
use App\Interfaces\FeedRepositoryInterface;
use App\Models\Post;

class FeedRepository implements FeedRepositoryInterface
{
    public function getMyFeed()
    {
        $user = auth()->user();

        if (!$user) {
            throw AuthExceptions::UserNotConnected();
        }

        $followsIds = $user->follows->pluck('id');
        $postsFromFollows = Post::whereIn('user_id', $followsIds)
            ->where('finished_at', '>', now())
            ->latest()
            ->take(10)
            ->get();

        $randomPosts = collect();

        if ($postsFromFollows->count() < 10) {
            $randomPosts = Post::whereNotIn('user_id', $followsIds)
                ->where('user_id', '!=', $user->id)
                ->where('finished_at', '>', now())
                ->inRandomOrder()
                ->take(10 - $postsFromFollows->count())
                ->get();
        }

        $feed = $postsFromFollows->merge($randomPosts);

        $sortedFeed = $feed->sortByDesc('created_at')->values();

        return $sortedFeed;
    }


    public function LoadUpFeed($firstPostId)
    {
        $user = auth()->user();

        if (!$user) {
            throw AuthExceptions::UserNotConnected();
        }

        if (!$firstPostId) {
            throw ObjectExcpetions::InvalidPost();
        }

        $followsIds = $user->follows->pluck('id');

        $postsFromFollows = Post::whereIn('user_id', $followsIds)
            ->where('finished_at', '>', now())
            ->where('id', '>', $firstPostId)
            ->latest()
            ->take(10)
            ->get();

        $randomPosts = collect();

        if ($postsFromFollows->count() < 10) {
            $randomPosts = Post::whereNotIn('user_id', $followsIds)
                ->where('user_id', '!=', $user->id)
                ->where('finished_at', '>', now())
                ->where('id', '>', $firstPostId)
                ->inRandomOrder()
                ->take(10 - $postsFromFollows->count())
                ->get();
        }

        $feed = $postsFromFollows->merge($randomPosts);
        $sortedFeed = $feed->sortByDesc('created_at')->values();

        return $sortedFeed;
    }
    public function LoadDownFeed($latestPostId)
    {
        $user = auth()->user();

        if (!$user) {
            throw AuthExceptions::UserNotConnected();
        }

        if (!$latestPostId) {
            throw ObjectExcpetions::InvalidPost();
        }

        $followsIds = $user->follows->pluck('id');

        $postsFromFollows = Post::whereIn('user_id', $followsIds)
            ->where('finished_at', '>', now())
            ->where('id', '<', $latestPostId)
            ->latest()
            ->take(10)
            ->get();

        $randomPosts = collect();

        if ($postsFromFollows->count() < 10) {
            $randomPosts = Post::whereNotIn('user_id', $followsIds)
                ->where('user_id', '!=', $user->id)
                ->where('finished_at', '>', now())
                ->where('id', '>', $latestPostId)
                ->inRandomOrder()
                ->take(10 - $postsFromFollows->count())
                ->get();
        }

        $feed = $postsFromFollows->merge($randomPosts);
        $sortedFeed = $feed->sortByDesc('created_at')->values();

        return $sortedFeed;
    }

    public function getFeedByUser($userId)
    {
        // make algorithm to get posts by user
        return Post::all();
    }
}
