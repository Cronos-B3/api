<?php

namespace App\Providers;

use App\Models\User\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Laravel\Pulse\Facades\Pulse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Pulse::user(function ($user) {
            $primaryEmail = $user->userEmails()->where('ue_primary', true)->first();

            $name = $user->u_firstname && $user->u_lastname
                ? $user->u_firstname . ' ' . $user->u_lastname
                : ($primaryEmail ? $primaryEmail->ue_email : 'Unknown');

            return [
                'name' => $user->u_id,
                'extra' => $user->u_role,
                'avatar' => 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->u_password ?? ''))),
            ];
        });
    }
}
