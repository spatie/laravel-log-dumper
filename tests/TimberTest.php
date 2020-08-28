<?php

namespace Spatie\LogDumper\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\LogDumper\Timber;
use Spatie\Snapshots\MatchesSnapshots;
use stdClass;

class TimberTest extends TestCase
{
    /** @test */
    public function ld_can_determine_the_location_of_an_ld_call()
    {
        Http::fake(function (Request $request) {
            $data = $request->data();
            $this->assertEquals(__FILE__, $data['file']);

            $this->requestMade = true;
        });

        ld('here');

        $this->assertTrue($this->requestMade ?? false);
    }

    /** @test */
    public function it_can_determine_the_log_location_even_when_chaining_functions()
    {
        Http::fake(function (Request $request) {
            $data = $request->data();
            $this->assertEquals(__FILE__, $data['file']);

            $this->requestMade = true;
        });

        ld()->color('green')->info('info');

        $this->assertTrue($this->requestMade ?? false);
    }

    /** @test */
    public function it_can_determine_the_log_location_when_the_info_function_is_used()
    {
        Http::fake(function (Request $request) {
            $data = $request->data();
            $this->assertEquals(__FILE__, $data['file']);

            $this->requestMade = true;
        });

        info('hey');

        $this->assertTrue($this->requestMade ?? false);
    }

    /** @test */
    public function it_can_determine_the_log_location_when_the_facade_is_used()
    {
        Http::fake(function (Request $request) {
            $data = $request->data();
            $this->assertEquals(__FILE__, $data['file']);

            $this->requestMade = true;
        });

        Log::info('hey');

        $this->assertTrue($this->requestMade ?? false);
    }

    /** @test */
    public function it_will_not_send_ld_calls_when_disabled()
    {
        config()->set(['log-dumper.timber.send_ld_calls' =>  false]);

        Http::fake(function (Request $request) {
            $data = $request->data();
            $this->assertEquals(__FILE__, $data['file']);

            $this->requestMade = true;
        });

        ld('hey');

        $this->assertFalse($this->requestMade ?? false);
    }

    /** @test */
    public function it_will_not_send_regular_log_calls_when_disabled()
    {
        config()->set(['log-dumper.timber.send_regular_log_calls' => false]);

        Http::fake(function (Request $request) {
            $data = $request->data();
            $this->assertEquals(__FILE__, $data['file']);

            $this->requestMade = true;
        });

        info('hey');
        Log::info('hey');

        $this->assertFalse($this->requestMade ?? false);
    }
}
