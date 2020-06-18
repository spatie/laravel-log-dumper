<?php

namespace Spatie\LogDumper;

use Carbon\Laravel\ServiceProvider;

class LogDumperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LogDumper::class);
    }
}
