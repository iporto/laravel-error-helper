<?php

namespace IPorto\LaravelErrorHelper;

use Illuminate\Support\ServiceProvider;

class ErrorHelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('laravel-error-helper', function ($app) {
            return new ErrorHelper();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}