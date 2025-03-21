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
        Gate::define('update-post', [PostPolicy::class, 'update']);
        Gate::define('delete-post', [PostPolicy::class, 'destroy']);

        // Employee Gate
        Gate::define('crud-employee', [EmployeePolicy::class, 'crud']);

        // Report Gate
        Gate::define('verification-report', [ReportPolicy::class, 'verification']);
        Gate::define('create-report', [ReportPolicy::class, 'create']);
        Gate::define('edit-report', [ReportPolicy::class, 'edit']);
    }
}
