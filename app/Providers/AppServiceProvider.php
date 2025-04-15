<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

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
        Paginator::useBootstrap();
        
        // Set application locale based on session
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            if (in_array($locale, ['en', 'ar'])) {
                App::setLocale($locale);
                // Set locale for Carbon dates
                setlocale(LC_TIME, $locale == 'ar' ? 'ar_SA.UTF-8' : 'en_US.UTF-8');
                // Set fallback locale
                Config::set('app.fallback_locale', 'en');
                // Set APP_LOCALE environment variable
                putenv("APP_LOCALE={$locale}");
            }
        }
    }
}
