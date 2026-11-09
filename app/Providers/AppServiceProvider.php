<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {
        $view->with('current_request', Request::segment(2));
    });

        View::composer(['auth.login', 'auth.member-phone', 'auth.member-otp'], function ($view) {
            $view->with('siteSettings', Setting::latest()->first());
        });
    }
}
