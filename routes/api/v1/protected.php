<?php


use App\Http\Controllers\API\v1\Card\CardController;
use App\Http\Controllers\API\v1\User\UserController;
use App\Http\Responses\SuccessResponses;
use Illuminate\Support\Facades\Route;

Route::get('/protected', function () {
    return SuccessResponses::ok(['message' => 'Protected']);
});

Route::group(['prefix' => 'users', 'controller' => UserController::class], function () {
    Route::patch('/', 'updateUser');
    Route::patch('/password', 'updatePassword');
});
