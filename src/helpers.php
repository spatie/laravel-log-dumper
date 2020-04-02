<?php

use Spatie\LogDumper\LogDumper;

if (! function_exists('ld')) {
    function ld(...$arguments) {
        (new LogDumper())->log(...$arguments);
    }
}
