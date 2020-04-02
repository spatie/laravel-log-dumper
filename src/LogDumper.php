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

    public function log(...$arguments)
    {
        foreach ($arguments as $argument) {
            $logOutput = $this->convertToString($argument);

            app('log')->info($logOutput);
        }
    }

    protected function convertToString($argument): string
    {
        $clonedArgument = $this->cloner->cloneVar($argument);

        return $this->dumper->dump($clonedArgument, true);
    }
}
