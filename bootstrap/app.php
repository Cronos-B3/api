<?php

use App\Classes\ApiResponseClass;
use App\Exceptions\CustomExceptions;
use App\Http\Middleware\EnsureUserHasAdminRole;
use App\Http\Middleware\EnsureUserIsConnected;
use App\Http\Middleware\TransformApiRequest;
use App\Http\Middleware\TransformApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        // api: __DIR__.'/../routes/api.php', 
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function ($router) {
            Route::prefix('api/v1')
                ->middleware('api')
                ->name('api.v1.')
                ->group(base_path('routes/api.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('auth', [
            EnsureUserIsConnected::class,
        ]);

        $middleware->appendToGroup('api', [
            TransformApiRequest::class,
            TransformApiResponse::class,
        ]);

        $middleware->appendToGroup('admin', [
            EnsureUserHasAdminRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->is('api/*');
        });

        // Custom renderable for InvalidPostException
        $exceptions->renderable(function (CustomExceptions $e, Request $request) {
            return ApiResponseClass::sendErrorResponse($e->getMessage(), $e->getCode());
        });

        $exceptions->renderable(function (Exception $e, Request $request) {
            return ApiResponseClass::sendErrorResponse($e->getMessage(), intval($e->getCode()) ?: 500);
        });
    })->create();
