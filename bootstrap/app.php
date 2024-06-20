<?php

use App\Classes\ApiResponseClass;
use App\Exceptions\CustomExceptions;
use App\Exceptions\InvalidPostException;
use App\Http\Middleware\EnsureUserIsConnected;
use App\Http\Middleware\TransformApiRequest;
use App\Http\Middleware\TransformApiResponse;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\ServerErrorResponses;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Console\View\Components\Mutators\EnsurePunctuation;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

use function Laravel\Prompts\alert;
use function Termwind\render;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__ . '/../routes/web.php',
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
            return ApiResponseClass::sendErrorResponse($e->getMessage(), $e->getCode() ?: 500);
        });
    })->create();
