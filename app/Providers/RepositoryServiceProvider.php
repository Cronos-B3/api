<?php

namespace App\Providers;

use App\Http\Controllers\Api\v1\FriendController;
use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\FeedRepositoryInterface;
use App\Interfaces\FriendRepositoryInterface;
use App\Interfaces\GroupRepositoryInterface;
use App\Interfaces\GroupUserRepositoryInterface;
use App\Interfaces\LikeRepositoryInterface;
use App\Interfaces\PostRepositoryInterface;
use App\Interfaces\UpvoteRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Repositories\FeedRepository;
use App\Repositories\FriendRepository;
use App\Repositories\GroupRepository;
use App\Repositories\GroupUserRepository;
use App\Repositories\LikeRepository;
use App\Repositories\PostRepository;
use App\Repositories\UpvoteRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(FeedRepositoryInterface::class, FeedRepository::class);
        $this->app->bind(LikeRepositoryInterface::class, LikeRepository::class);
        $this->app->bind(UpvoteRepositoryInterface::class, UpvoteRepository::class);
        $this->app->bind(FriendRepositoryInterface::class, FriendRepository::class);
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
        $this->app->bind(GroupUserRepositoryInterface::class, GroupUserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
