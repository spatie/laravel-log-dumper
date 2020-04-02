<?php

namespace Spatie\LogDumper;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\VarDumper;

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
        if ($argument instanceof Model) {
            $argument = $argument->toArray();
            VarDumper::dump($argument);
        }

        $clonedArgument = $this->cloner->cloneVar($argument);

        ob_start();
        $output = $this->dumper->dump($clonedArgument, true);
        ob_get_clean();

        return $output;
    }
}
