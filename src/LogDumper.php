<?php

namespace Spatie\LogDumper;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;

class LogDumper
{
    protected VarCloner $cloner;

    protected CliDumper $dumper;

    protected LogServer $logServer;

    protected bool $enabled = true;

    public string $color = '';

    public string $textStyle = '';

    protected $listenForQueries = false;

    protected $queryListenerRegistered = false;


    public function __construct()
    {
        $this->cloner = new VarCloner();

        $this->dumper = new CliDumper();

        $this->logServer = new LogServer();
    }

    public function debug(...$arguments): self
    {
        return $this->log('debug', ...$arguments);
    }

    public function notice(...$arguments): self
    {
        return $this->log('notice', ...$arguments);
    }

    public function info(...$arguments): self
    {
        return $this->log('info', ...$arguments);
    }

    public function alert(...$arguments): self
    {
        return $this->log('alert', ...$arguments);
    }

    public function warning(...$arguments): self
    {
        return $this->log('warning', ...$arguments);
    }

    public function error(...$arguments): self
    {
        return $this->log('error', ...$arguments);
    }

    public function critical(...$arguments): self
    {
        return $this->log('critical', ...$arguments);
    }

    public function emergency(...$arguments): self
    {
        return $this->log('emergency', ...$arguments);
    }

    public function enable(bool $enabled = true): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function disable(): self
    {
        $this->enabled = false;

        return $this;
    }

    public function logQueries($callable = null): self
    {
        $wasLoggingQueries = $this->listenForQueries;

        $this->startLoggingQueries();

        if (! is_null($callable)) {
            $callable();

            if (! $wasLoggingQueries) {
                $this->stopLoggingQueryies();
            }
        }

        return $this;
    }

    public function startLoggingQueries(): self
    {
        DB::enableQueryLog();

        $this->listenForQueries = true;

        if (! $this->queryListenerRegistered) {
            DB::listen(function (QueryExecuted $query) {
                if ($this->listenForQueries) {
                    $this->info($query->sql);
                }
            });

            $this->queryListenerRegistered = true;
        }


        return $this;
    }

    public function stopLoggingQueryies(): self
    {
        DB::disableQueryLog();

        $this->listenForQueries = false;

        return $this;
    }

    public function color(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function clear(): self
    {
        $this->logServer->clearScreen();

        return $this;
    }

    public function separator(): self
    {
        //TODO: implement

        return $this;
    }

    public function large(): self
    {
        $this->textStyle = '3xl';

        return $this;
    }

    public function log(string $method, ...$arguments): self
    {
        if (! $this->enabled) {
            return $this;
        }

        foreach ($arguments as $argument) {
            $logOutput = $this->convertToString($argument);

            app('log')->$method($logOutput, ['sentToLogServer' => 1]);

            $style = ['color' => $this->color];

            if ($method === 'error') {
                $style = ['color' => 'red'];
            }

            if ($method === 'warn') {
                $style = ['color' => 'yellow'];
            }

            $style['text'] = $this->textStyle;

            $this->logServer->log($logOutput, $style);
        }

        return $this;
    }

    protected function convertToString($argument): string
    {
        $clonedArgument = $this->cloner->cloneVar($argument);

        $string = $this->dumper->dump($clonedArgument, true);

        $string = rtrim($string, PHP_EOL);

        return trim($string, '"');
    }
}
