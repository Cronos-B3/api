<?php

namespace App\Exceptions;

use App\Http\Responses\ErrorResponses;
use Error;
use App\Http\Responses\ServerErrorResponses;
use App\Logs\Logs;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function report(Throwable $exception)
    {
        Logs::crash($exception->getMessage(), $exception->getFile(), $exception->getLine());
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return ErrorResponses::unauthorized([], ['message' => 'Unauthenticated']);
        }
        // Handle ModelNotFoundException specifically  -> not find object in url
        if ($exception instanceof ModelNotFoundException) {
            return ErrorResponses::notFound([], ['message' => 'Resource not found']);
        }
        if ($exception instanceof QueryException) {
            return ServerErrorResponses::internalServerError(['message' => 'Database query error']);
        }
        if ($exception instanceof NotFoundHttpException) {
            return ErrorResponses::notFound([], ['message' => 'URL not found']);
        }

        // Existing logic for handling other exceptions in production
        if (app()->environment('production')) {
            return ServerErrorResponses::internalServerError();
        }

        // Existing logic for handling other exceptions in non-production environments
        return ServerErrorResponses::internalServerError([
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
    }
}
