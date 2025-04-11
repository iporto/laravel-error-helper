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
        // Publicar as views de exemplo
        $this->publishes([
            __DIR__.'/../resources/views/errors' => resource_path('views/errors'),
        ], 'laravel-error-helper-views');
    }
}