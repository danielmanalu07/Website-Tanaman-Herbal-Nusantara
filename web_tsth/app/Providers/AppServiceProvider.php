<?php
namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        // Gunakan app_language_user jika tersedia, kalau tidak pakai app_language
        $locale = session('app_language_user', session('app_language', config('app.locale')));
        app()->setLocale($locale);
    }

}
