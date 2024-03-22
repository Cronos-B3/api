<?php

use App\Http\Controllers\API\v1\CommentsController;
use App\Http\Controllers\API\v1\CronController;
use App\Http\Controllers\API\v1\CronLikesController;
use App\Http\Controllers\API\v1\UpVoteController;
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

    //cron 
    Route::get('/', 'getCrons');
    Route::get('/{crondId}', 'getCron');
    Route::post('/', 'createCron');

    //likes
    Route::post('/{cronId}/like', [CronLikesController::class, 'store']);
    Route::get('/{cronId}/likes', [CronLikesController::class, 'getCronLikes']);

    //upvotes
    Route::post('/{cronId}/upvote', [UpVoteController::class, 'store']);
    Route::get('/{cronId}/upvotes', [UpVoteController::class, 'getCronUpVotes']);

    //comments
    Route::get('/{cronId}/comments', [CommentsController::class, 'index']);
});
