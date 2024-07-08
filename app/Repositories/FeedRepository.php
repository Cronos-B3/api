<?php

namespace App\Repositories;

use App\Exceptions\ObjectExcpetions;
use App\Interfaces\FeedRepositoryInterface;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;

class FeedRepository implements FeedRepositoryInterface
{
    protected $TOTAL_POSTS;

    public function __construct()
    {
        $this->TOTAL_POSTS = 10;
    }

    public function getMyFeed()
    {
        $user = $this->getAuthenticatedUser();

        $myLatestPosts = $this->getUserPosts($user, 1);
        $feed = $this->getFeed($user, $myLatestPosts, now(), $this->TOTAL_POSTS);

        return $feed;
    }

    public function LoadUpFeed($firstPostId)
    {
        $user = $this->getAuthenticatedUser();
        $this->validatePostId($firstPostId);

        $feed = $this->getFeed($user, collect(), now(), $this->TOTAL_POSTS, '>', $firstPostId);

        return $feed;
    }

    public function LoadDownFeed($latestPostId)
    {
        $user = $this->getAuthenticatedUser();
        $this->validatePostId($latestPostId);

        $feed = $this->getFeed($user, collect(), now(), $this->TOTAL_POSTS, '<', $latestPostId);

        return $feed;
    }

    public function getFeedByUser($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw ObjectExcpetions::InvalidUser();
        }
        return $this->getFeed($user, collect(), now(), $this->TOTAL_POSTS);
    }

    public function LoadUpFeedByUser($userId, $firstPostId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw ObjectExcpetions::InvalidUser();
        }

        $this->validatePostId($firstPostId);

        $feed = $this->getFeed($user, collect(), now(), $this->TOTAL_POSTS, '>', $firstPostId);

        return $feed;
    }

    public function LoadDownFeedByUser($userId, $latestPostId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw ObjectExcpetions::InvalidUser();
        }

        $this->validatePostId($latestPostId);

        $feed = $this->getFeed($user, collect(), now(), $this->TOTAL_POSTS, '<', $latestPostId);

        return $feed;
    }

    private function getAuthenticatedUser()
    {
        return auth()->user();
    }

    private function validatePostId($postId)
    {
        if (!$postId) {
            throw ObjectExcpetions::InvalidPost();
        }
    }

    private function getUserPosts($user, $limit)
    {
        return $user->posts()
            ->where('finished_at', '>', now())
            ->with(['user', 'userLiked', 'userUpvoted'])
            ->withCount(['likes', 'upvotes', 'comments'])
            ->latest()
            ->take($limit)
            ->get();
    }

    private function getFeed($user, Collection $myLatestPosts, $date, $limit, $operator = null, $postId = null)
    {
        $followsIds = $user->follows->pluck('id');

        // Prepare query for get posts from follows 
        $postsQuery = Post::whereIn('user_id', $followsIds)
            ->where('finished_at', '>', $date)
            ->with(['user', 'userLiked', 'userUpvoted'])
            ->withCount(['likes', 'upvotes', 'comments'])
            ->latest();

        // condition if loadUp or LoadDown
        if ($operator && $postId) {
            $postsQuery->where('id', $operator, $postId);
        }

        // Get distinct user posts from follows
        $postsFromFollows = $postsQuery->get()->groupBy('user_id')->map->first()->values();
        $postsFromFollows = $postsFromFollows->take($limit - $myLatestPosts->count());

        $randomPosts = collect();

        // Get random Post if limit > 0
        if ($postsFromFollows->count() < $limit) {
            $randomPostsQuery = Post::whereNotIn('user_id', $followsIds)
                ->where('user_id', '!=', $user->id)
                ->where('finished_at', '>', $date)
                ->with(['user', 'userLiked', 'userUpvoted'])
                ->withCount(['likes', 'upvotes', 'comments'])
                ->inRandomOrder();

            if ($operator && $postId) {
                $randomPostsQuery->where('id', $operator, $postId);
            }

            // Get distinct random user posts
            $randomPosts = $randomPostsQuery->get()->groupBy('user_id')->map->first()->values();
            $randomPosts = $randomPosts->take($limit - $postsFromFollows->count());
        }

        $feed = $postsFromFollows->merge($randomPosts->merge($myLatestPosts));

        return $feed->sortByDesc('created_at')->values();
    }
}
