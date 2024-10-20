<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('administrar', function (User $user) {
            return $user->user_type === 'A';
        });
        Gate::define('access-cart', function (?User $user) {
            return $user === null || $user->user_type === 'C';
        });

        Blade::directive('adminF', function () {
            return "<?php if(Auth::user() && (Auth::user()->user_type == 'A' || Auth::user()->user_type == 'E')): ?>";
        });

        Blade::directive('endadminF', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('admin', function () {
            return "<?php if(Auth::user() && (Auth::user()->user_type == 'A')): ?>";
        });

        Blade::directive('endadmin', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('employee', function () {
            return "<?php if(Auth::user() && Auth::user()->user_type === 'E'): ?>";
        });

        Blade::directive('endemployee', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('EXCEPTemployee', function () {
            return "<?php if(Auth::user() && Auth::user()->user_type !== 'E'): ?>";
        });

        Blade::directive('endEXCEPTemployee', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('customer', function () {
            return "<?php if(Auth::user() && Auth::user()->user_type === 'C'): ?>";
        });

        Blade::directive('endcustomer', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('authUser', function () {
            return "<?php if(Auth::user()): ?>";
        });

        Blade::directive('endauthUser', function () {
            return "<?php endif; ?>";
        });

    }
}
