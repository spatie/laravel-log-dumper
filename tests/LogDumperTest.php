<?php

namespace Spatie\LogDumper\Tests;

use Illuminate\Support\Facades\Log;
use Orchestra\Testbench\TestCase;
use Spatie\Snapshots\MatchesSnapshots;
use stdClass;

class LogDumperTest extends TestCase
{
    use MatchesSnapshots;

    public function setUp(): void
    {
        parent::setUp();

        Log::swap(new LogFake());
    }

    /** @test */
    public function it_can_log_a_single_thing()
    {
        ld('test');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    /** @test */
    public function it_can_log_multiple_things()
    {
        ld('test', 'test2');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }
    /** @test */
    public function it_can_chaine_multiple_logs()
    {
        ld('test', 'test2')->error('test3')->critical('test4');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    /** @test */
    public function it_can_log_an_array()
    {
        ld(['a' => 1, 'b' => 2]);

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    /** @test */
    public function it_can_log_an_object()
    {
        ld(new StdClass());

        $this->assertNotEmpty(Log::getLinesAsString());
    }

    /** @test */
    public function it_will_not_blow_up_when_passing_no_exceptions()
    {
        ld();

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }
}
