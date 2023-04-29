<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        $url        = "http://";
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $url    = "https://";
        }
        //$_SERVER['HTTP_HOST']
        $websiteBaseUrl = $url . request()->getHost() . '/';
        if ($_SERVER['SERVER_NAME'] == 'localhost') {
            $websiteBaseUrl = $url . request()->getHost() . '/profrea/';
        }
        
        View::share(['websiteBaseUrl' => $websiteBaseUrl]);
    }
}
