<?php

use Spatie\LogDumper\LogDumper;

if (! function_exists('ld')) {
    function ld(...$arguments) : LogDumper
    {
        return (new LogDumper())->log(...$arguments);
    }
}
