<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Responses\SuccessResponses;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return SuccessResponses::ok();
});

Route::group(['prefix' => 'register', 'controller' => RegisterController::class], function () {
    Route::post('/', 'store');
    Route::post('/email-exist', 'EmailExist');
});

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout']);
