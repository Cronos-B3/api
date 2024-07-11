<?php

namespace App\Http\Middleware;

use App\Classes\ApiResponseClass;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Assurez-vous que l'utilisateur est connecté et a le rôle ADMIN
        if (!Auth::check() || !Auth::user()->role === 'ADMIN'){
            // Si l'utilisateur n'est pas un admin, renvoyez une réponse d'accès refusé
            return ApiResponseClass::sendErrorResponse('Access denied.', Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
