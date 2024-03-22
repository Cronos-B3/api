<?php

use App\Http\Controllers\API\v1\CronController;
use App\Http\Controllers\API\v1\UserController;
use App\Http\Responses\SuccessResponses;
use Illuminate\Support\Facades\Route;

Route::get('/protected', function () {
    return SuccessResponses::ok(['message' => 'Protected']);
});

Route::group(['prefix' => 'users', 'controller' => UserController::class], function () {
    Route::get('/', 'getUsers');
    Route::patch('/', 'updateUser');
    Route::patch('/password', 'updatePassword');
});

Route::group(['prefix' => 'crons', 'controller' => CronController::class], function () {
    Route::get('/', 'getCron');
    Route::post('/', 'createCron');
});
