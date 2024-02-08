<?php

namespace App\Http\Middleware;

use App\Http\Responses\ErrorResponses;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{

    /**
     * Handle an unauthenticated user.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson();
    }
}
