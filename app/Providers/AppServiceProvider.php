<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('dateFormat', function ($expression) {
            return "<?php echo Carbon\Carbon::parse($expression)->format('d-m-y'); ?>";
        });

        Blade::directive('encryptValueForUrl', function ($expression) {
            return "<?php echo urlencode(Crypt::encrypt($expression)); ?>";
        });

        Blade::directive('dateFormatWithSlash', function ($expression) {
            return "<?= \Carbon\Carbon::parse($expression)->format('m/d/Y'); ?>";
        });

        Blade::directive('dateWithDay', function ($expression) {
            return "<?= \Carbon\Carbon::parse($expression)->format('d/m/Y'); ?>";
        });
    }
}
