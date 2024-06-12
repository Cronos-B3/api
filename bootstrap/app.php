<?php

use App\Http\Middleware\TransformApiRequest;
use App\Http\Middleware\TransformApiResponse;
use App\Http\Responses\ErrorResponses;
use App\Http\Responses\ServerErrorResponses;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

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
        $middleware->appendToGroup('api', [
            TransformApiRequest::class,
            TransformApiResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->is('*');
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                switch (true) {
                    case $e instanceof AuthenticationException:
                        return ErrorResponses::unauthorized(['message' => __('errors.http_responses.unauthorized')]);
                    case $e instanceof NotFoundHttpException:
                    case $e instanceof RouteNotFoundException:
                        return ErrorResponses::notFound(['message' => __('errors.http_responses.not_found')]);
                    case $e instanceof BadRequestHttpException:
                        return ErrorResponses::badRequest(['message' => __('errors.http_responses.bad_request')]);
                    case $e instanceof MethodNotAllowedHttpException:
                        return ErrorResponses::methodeNotAllowed(['message' => __('errors.http_responses.method_not_allowed')]);
                    case $e instanceof UnprocessableEntityHttpException:
                    case $e instanceof ValidationException:
                        return ErrorResponses::unprocessable(['message' => __('errors.http_responses.unprocessable_entity')]);
                    default:
                        return ServerErrorResponses::internalServerError(['message' => __('errors.http_responses.internal_server_error'), 'errors'=> $e->getMessage()]);
                }
            }
            return null; // Laisser Laravel gérer l'exception normalement pour les requêtes non API
        });
    })->create();
