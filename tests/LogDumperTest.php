<?php

namespace Spatie\LogDumper\Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Snapshots\MatchesSnapshots;
use stdClass;

class LogDumperTest extends TestCase
{
    use MatchesSnapshots;

    #[Test]
    public function it_can_log_a_single_thing()
    {
        ld('test');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_log_multiple_things()
    {
        ld('test', 'test2');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_log_an_array()
    {
        ld(['a' => 1, 'b' => 2]);

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_log_an_object()
    {
        ld(new StdClass());

        $this->assertTrue(true);
    }

    #[Test]
    public function it_will_not_blow_up_when_passing_no_exceptions()
    {
        ld();

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_log_debug_level_stuff()
    {
        ld()->debug('string');

        ld()->debug(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_log_using_the_notice_level()
    {
        ld()->notice('string');

        ld()->notice(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_log_using_the_info_level()
    {
        ld()->info('string');

        ld()->info(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_log_using_the_alert_level()
    {
        ld()->alert('string');

        ld()->alert(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_log_using_the_warning_level()
    {
        ld()->warning('string');

        ld()->warning(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_log_using_the_error_level()
    {
        ld()->error('string');

        ld()->error(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_log_using_the_critical_level()
    {
        ld()->critical('string');

        ld()->critical(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }


    #[Test]
    public function it_can_log_using_the_emergency_level()
    {
        ld()->emergency('string');

        ld()->emergency(['a' => 1], 'another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }


    #[Test]
    public function it_can_mix_levels()
    {
        ld()->emergency('string');

        ld()->error(['a' => 1], 'another string')->emergency(['b' => 1], 'yet another string');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_disable_output()
    {
        ld()->disable();

        ld()->info('ignored');
        ld()->error('also ignored');

        $this->assertCount(0, Log::getLines());

        ld()->enable();

        ld()->info('ignored');

        $this->assertCount(1, Log::getLines());
    }

    #[Test]
    public function enable_accepts_a_boolean()
    {
        foreach (range(1, 3) as $i) {
            // only things in the third iteration will be logged
            ld()->enable($i === 3);

            ld('we are in the third iteration');
        }

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_start_logging_queries()
    {
        ld()->logQueries();

        DB::table('users')->get('id');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_stop_logging_queries()
    {
        ld()->logQueries();

        DB::table('users')->get('id');

        ld()->stopLoggingQueries();

        DB::table('users')->get('id');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function calling_log_queries_twice_will_not_log_all_queries_twice()
    {
        ld()->logQueries();
        ld()->logQueries();

        DB::table('users')->get('id');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }

    #[Test]
    public function it_can_log_all_queries_in_a_callable()
    {
        ld()->logQueries(function () {
            // will be logged
            DB::table('users')->where('id', 1)->get();
        });

        // will not be logged
        DB::table('users')->get('id');

        $this->assertMatchesSnapshot(Log::getLinesAsString());
    }
}
