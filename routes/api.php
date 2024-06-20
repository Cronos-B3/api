<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\PostController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('/test', function () {
        return new JsonResponse(["response" => "test is good"], Response::HTTP_OK);
    });

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login')->name('login');
    });

    Route::middleware('auth')->group(function () {
        Route::prefix('posts')->controller(PostController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/{post}', 'showById');
            Route::get('/feed', 'showMyFeed');
            Route::get('/feed/{User}', 'showFeedByUser');
            Route::post('/', 'store');
            Route::patch('/{Post}', 'update');
            Route::delete('/{Post}', 'delete');
        });
    });
});
