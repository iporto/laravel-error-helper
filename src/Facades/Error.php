<?php

namespace IPorto\LaravelErrorHelper\Facades;

use Illuminate\Support\Facades\Facade;

class Error extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-error-helper';
    }
}