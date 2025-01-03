<?php

namespace App\Providers;

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
        if (!array_key_exists('HOME', $_SERVER)) {
            $_SERVER['HOME'] = base_path();  // Set path Laravel base jika tidak ada variabel HOME
        }
    }
}
