<?php

namespace Spatie\LogDumper;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;

class LogDumper
{
    const ALERT = 'alert';
    const INFO = 'info';
    const EMERGENCY = 'emergency';
    const CRITICAL = 'critical';
    const ERROR = 'error';
    const WARNING = ' warning';
    const NOTICE = 'notice';
    const DEBUG = 'debug';
    private VarCloner $cloner;
    private CliDumper $dumper;
    /**
     * @var string
     */
    private string $logLevel;

    public function __construct()
    {
        $this->cloner = new VarCloner();

        $this->dumper = new CliDumper();

        $this->logLevel = self::INFO;
    }

    public function emergency(...$arguments)
    {
        $this->logLevel = self::EMERGENCY;

        return $this->log($arguments);
    }

    public function log(...$arguments): LogDumper
    {
        foreach ($arguments as $argument) {
            $logOutput = $this->convertToString($argument);

            $this->logged($logOutput);
        }

        return $this;
    }

    protected function convertToString($argument): string
    {
        $clonedArgument = $this->cloner->cloneVar($argument);

        return $this->dumper->dump($clonedArgument, true);
    }

    /**
     * @param string $logOutput
     */
    protected function logged(string $logOutput): void
    {
        switch ($this->logLevel) {
            case self::EMERGENCY:
                app('log')->emergency($logOutput);

                break;
            case self::ALERT:
                app('log')->alert($logOutput);

                break;
            case self::CRITICAL:
                app('log')->critical($logOutput);

                break;
            case self::ERROR:
                app('log')->error($logOutput);

                break;
            case self::WARNING:
                app('log')->warning($logOutput);

                break;
            case self::NOTICE:
                app('log')->notice($logOutput);

                break;
            case self::INFO:
                app('log')->info($logOutput);

                break;
            case self::DEBUG:
                app('log')->debug($logOutput);

                break;
        }
    }

    public function alert(...$arguments)
    {
        $this->logLevel = self::ALERT;

        return $this->log($arguments);
    }

    public function critical(...$arguments)
    {
        $this->logLevel = self::CRITICAL;

        return $this->log($arguments);
    }

    public function error(...$arguments)
    {
        $this->logLevel = self::ERROR;

        return $this->log($arguments);
    }

    public function warning(...$arguments)
    {
        $this->logLevel = self::WARNING;

        return $this->log($arguments);
    }

    public function notice(...$arguments)
    {
        $this->logLevel = self::NOTICE;

        return $this->log($arguments);
    }

    public function info(...$arguments)
    {
        $this->logLevel = self::INFO;

        return $this->log($arguments);
    }

    public function debug(...$arguments)
    {
        $this->logLevel = self::DEBUG;

        return $this->log($arguments);
    }
}
