<?php

use Spatie\LogDumper\LogDumper;

if (! function_exists('ld')) {
    function ld(...$arguments): LogDumper
    {
        return app(LogDumper::class)->info(...$arguments);
    }
}
