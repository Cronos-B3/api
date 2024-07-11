<?php

use App\Http\Controllers\Api\v1\AdminController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\FeedController;
use App\Http\Controllers\Api\v1\FriendController;
use App\Http\Controllers\Api\v1\GroupController;
use App\Http\Controllers\Api\v1\GroupUserController;
use App\Http\Controllers\Api\v1\LikeController;
use App\Http\Controllers\Api\v1\PostController;
use App\Http\Controllers\Api\v1\UpvoteController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\UserGroupController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('/test', function () {
        return new JsonResponse(["response" => "test is good"], Response::HTTP_OK);
    });

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login')->name('login');
        Route::post('/admin/login', [AdminController::class, 'login']);

    });

    Route::middleware('auth')->group(function () {
        Route::get('/me', [UserController::class, 'me'])->name('me');
        Route::get('/me/posts', [PostController::class, 'showMyPosts']);
        Route::patch('/me', [UserController::class, 'update']);
        Route::delete('/me', [UserController::class, 'delete']);

        Route::prefix('users')->controller(UserController::class)->group(function () {
            Route::get('/{userId}', 'showUserById');
            Route::get('/{userId}/posts', [PostController::class, 'showByUserId']);
        });

        Route::prefix('posts')->controller(PostController::class)->group(function () {
            Route::post('/', 'store');
            Route::get('/{postId}', 'showById');
            Route::post('/{postId}/comments', 'storeComment');
            Route::get('/{postId}/comments', 'getComments');

            Route::prefix('/{postId}/likes')->controller(LikeController::class)->group(function () {
                Route::post('/', 'like');
                Route::delete('/', 'unlike');
                Route::get('/', 'showLikes');
            });

            Route::prefix('/{postId}/upvotes')->controller(UpvoteController::class)->group(function () {
                Route::post('/', 'upvote');
                Route::delete('/', 'undoUpvote');
                Route::get('/', 'showUpvotes');
            });
        });

        Route::prefix('feed')->controller(FeedController::class)->group(function () {
            Route::get('/', 'showMyFeed');
            Route::get('/up/{firstPostId}', 'loadUpFeed');
            Route::get('/down/{lastPostId}', 'loadDownFeed');
            Route::get('/{userId}', 'showFeedUser');
            Route::get('/{userId}/up/{firstPostId}', 'loadUpFeedUser');
            Route::get('/{userId}/down/{lastPostId}', 'loadDownFeedUser');
        });

        Route::prefix('friends')->controller(FriendController::class)->group(function () {
            Route::get('/follows', 'showMyFollows');
            Route::get('/followers', 'showMyFollowers');
            Route::post('/follow/{userId}', 'follow');
            Route::delete('/unfollow/{userId}', 'unFollow');
            Route::get('/follows/{userId}', 'showFollowsByUser');
            Route::get('/followers/{userId}', 'showFollowersByUser');
        });

        // Route::get('/search', [UserController::class, 'search']);

        Route::prefix('groups')->controller(GroupController::class)->group(function () {
            Route::post('/', 'store');
            Route::get('/', 'showMyGroups');
            Route::get('/{groupId}', 'showById');
            Route::patch('/{groupId}', 'update');
            Route::delete('/{groupId}', 'delete');
        });

        Route::prefix('group-users')->controller(GroupUserController::class)->group(function () {
            Route::post('/{groupId}/{code}', 'store');
            Route::delete('/{groupId}', 'delete');
        });
    });

    // Route::prefix('admin/dashboard')->middleware('admin')->group(function () {
    //     Route::get('/users', [UserController::class, 'index']);
    // });

    Route::middleware('admin')->group(function () {
        Route::controller(AdminController::class)->prefix('admin/dashboard')->group(function () {
            Route::prefix('users')->group(function () {
                Route::get('/', 'indexUser');
                Route::get('/{userId}', 'showUserById');
                Route::patch('/{userId}', 'updateByUserId');
                Route::delete('/{userId}', 'deleteUser');
            });

            Route::prefix('posts')->group(function () {
                Route::get('/', 'indexPost');
                Route::get('/{postId}', 'showPostById');
                Route::delete('/{postId}', 'deletePost');
            });
        });
    });
});
