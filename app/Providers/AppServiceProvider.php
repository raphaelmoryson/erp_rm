<?php

namespace App\Providers;

use App\View\Components\ConfirmationModal;
use Blade;
use Illuminate\Pagination\Paginator;
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
        Blade::component('confirmation-modal', ConfirmationModal::class);
        Paginator::useBootstrap();
    }
}
