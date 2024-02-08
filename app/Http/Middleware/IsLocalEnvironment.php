<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsLocalEnvironment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!app()->environment('local')) {
            // Retourner une réponse ou rediriger l'utilisateur si pas en environnement local
            return response('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
