<?php

namespace Spatie\LogDumper\Tests;

use Illuminate\Support\Facades\Log;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LogDumper\LogDumperServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Log::swap(new LogFake());
    }

    protected function getPackageProviders($app)
    {
        return [
            LogDumperServiceProvider::class,
        ];
    }
}
