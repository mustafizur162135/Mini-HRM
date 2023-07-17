<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

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
       // Get the preferred language from user preferences or session
    $preferredLanguage = Session::get('preferred_language', 'bn'); // Assuming the default language is English

    // Set the preferred language
    App::setLocale($preferredLanguage);
    }
}
