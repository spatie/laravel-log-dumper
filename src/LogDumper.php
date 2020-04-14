<?php

namespace Spatie\LogDumper;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;

class LogDumper
{
    private VarCloner $cloner;

    private CliDumper $dumper;

    public function __construct()
    {
        $this->cloner = new VarCloner();

        $this->dumper = new CliDumper();
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

    public function log(string $method, ...$arguments): self
    {
        foreach ($arguments as $argument) {
            $logOutput = $this->convertToString($argument);

            app('log')->$method($logOutput);
        }

        return $this;
    }

    protected function convertToString($argument): string
    {
        $clonedArgument = $this->cloner->cloneVar($argument);

        return $this->dumper->dump($clonedArgument, true);
    }
}
