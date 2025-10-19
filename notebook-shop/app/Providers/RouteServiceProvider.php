<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Determine redirect path after login based on user role.
     */
    public static function redirectTo()
    {
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            // redirect admin to dashboard
            return '/admin/dashboard';
        }

        // everyone else (customer)
        return '/';
    }
}
