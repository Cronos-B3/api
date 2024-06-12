<?php

use App\Http\Controllers\Api\v1\AuthController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('/test', function () {
        return new JsonResponse(["response" => "test is good"], Response::HTTP_OK);
    });

    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    Route::middleware('auth:api')->group(function () {

    });
});
