<?php

namespace Spatie\LogDumper;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;

class LogDumperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/log-dumper.php' => config_path('log-dumper.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->app->singleton(LogDumper::class);

        $this->mergeConfigFrom(__DIR__ . '/../config/log-dumper.php', 'log-dumper');

        Event::listen(MessageLogged::class, function (MessageLogged $message) {
            if (! config('log-dumper.timber.send_regular_log_calls')) {
                return;
            }

            if (Arr::has($message->context, 'sentToTimber')) {
                return;
            }

            if ($message->level === 'error') {
                $style = ['color' => 'red'];
            }

            if ($message->level === 'warning') {
                $style = ['color' => 'yellow'];
            }

            (new Timber())->log($message->message, $style ?? []);
        });
    }
}
