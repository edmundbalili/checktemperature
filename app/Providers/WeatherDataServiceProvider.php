<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WeatherDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('MergeWeatherService','App\Services\MergeWeatherService');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
