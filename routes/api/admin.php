<?php

use App\Http\Responses\SuccessResponses;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return SuccessResponses::ok();
});
