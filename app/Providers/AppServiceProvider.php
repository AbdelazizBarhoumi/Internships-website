<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Policies\AdminPolicy;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    protected $policies = [
        // Other policies...
        User::class => AdminPolicy::class,
    ];
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    // Define a gate for employer access
    Gate::define('employer', function (User $user) {
        return $user->isEmployer();
    });
    Gate::define('access-admin', [AdminPolicy::class, 'accessAdmin']);
        Gate::define('manage-users', [AdminPolicy::class, 'manageUsers']);
        Gate::define('promote-users', [AdminPolicy::class, 'promoteUsers']);
        Gate::define('demote-admins', [AdminPolicy::class, 'demoteAdmins']);
}
}
