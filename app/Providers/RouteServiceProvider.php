<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')->prefix('api')->group(function () {
                Route::middleware('local')->prefix('test')->group(base_path('routes/api/test.php'));

                Route::prefix('v1')->group(function () {
                    require base_path('routes/api/v1/public.php');
                    Route::middleware('auth:api')->group(base_path('routes/api/v1/protected.php'));
                });

                Route::prefix('auth')->group(base_path('routes/api/auth.php'));
                Route::prefix('admin')->group(base_path('routes/api/admin.php'));
            });

            // Route::middleware('web')
            //     ->group(base_path('routes/web.php'));
        });
    }
}
