<?php

use App\Http\Responses\SuccessResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/public', function (Request $request) {
    return SuccessResponses::ok(['message' => 'Public']);
});
