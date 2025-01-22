<?php

namespace App\Providers;

use App\Policies\EmployeePolicy;
use App\Policies\PostPolicy;
use App\Policies\ReportPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Post Gate
        Gate::define('update_delete-post', [PostPolicy::class, 'updateDelete']);

        // Employee Gate
        Gate::define('create-employee', [EmployeePolicy::class, 'create']);
        Gate::define('show-employee', [EmployeePolicy::class, 'show']);
        Gate::define('update_delete-employee', [EmployeePolicy::class, 'updateDelete']);

        // Report Gate
        Gate::define('verification-report', [ReportPolicy::class, 'verification']);
    }
}
