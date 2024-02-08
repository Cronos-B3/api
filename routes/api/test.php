<?php

use App\Http\Responses\ErrorResponses;
use App\Http\Responses\SuccessResponses;
use App\Jobs\ExampleJob;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Test Routes
|--------------------------------------------------------------------------
|
| Here is where you can register test routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "test" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return SuccessResponses::ok();
});

Route::get('/queue-connection', function () {
    return SuccessResponses::ok(['queue_connection' => config('queue.default')]);
});

Route::get('/redis-queue', function () {
    ExampleJob::dispatch();
    return SuccessResponses::ok();
});

Route::get('/failed', function () {
    return ErrorResponses::forbidden();
});

Route::get('/no_content', function () {
    return SuccessResponses::noContent();
});
