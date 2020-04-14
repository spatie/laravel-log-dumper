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
    public function it_can_log_an_array()
    {
        ld(['a' => 1, 'b' => 2]);

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    /** @test */
    public function it_can_log_an_object()
    {
        ld(new StdClass());

        $this->assertTrue(true);
    }

    /** @test */
    public function it_will_not_blow_up_when_passing_no_exceptions()
    {
        ld();

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    /** @test */
    public function it_can_log_debug_level_stuff()
    {
        ld()->debug('string');

        ld()->debug(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    /** @test */
    public function it_can_log_using_the_notice_level()
    {
        ld()->notice('string');

        ld()->notice(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    /** @test */
    public function it_can_log_using_the_info_level()
    {
        ld()->info('string');

        ld()->info(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    /** @test */
    public function it_can_log_using_the_alert_level()
    {
        ld()->alert('string');

        ld()->alert(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    /** @test */
    public function it_can_log_using_the_warning_level()
    {
        ld()->warning('string');

        ld()->warning(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    /** @test */
    public function it_can_log_using_the_error_level()
    {
        ld()->error('string');

        ld()->error(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    /** @test */
    public function it_can_log_using_the_critical_level()
    {
        ld()->critical('string');

        ld()->critical(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }


    /** @test */
    public function it_can_log_using_the_emergency_level()
    {
        ld()->emergency('string');

        ld()->emergency(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }


    /** @test */
    public function it_can_mix_levels()
    {
        ld()->emergency('string');

        ld()->error(['a' => 1], 'another string')->emergency(['b' => 1], 'yet another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }
}
