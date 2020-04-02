<?php

namespace Spatie\LogDumper\Tests;

use Psr\Log\LoggerInterface;

class LogFake implements LoggerInterface
{
    public array $lines = [];

    public function emergency($message, array $context = [])
    {
        $this->lines[] = $message;
    }

    public function alert($message, array $context = [])
    {
        $this->lines[] = $message;
    }

    public function critical($message, array $context = [])
    {
        $this->lines[] = $message;
    }

    public function error($message, array $context = [])
    {
        $this->lines[] = $message;
    }

    public function warning($message, array $context = [])
    {
        $this->lines[] = $message;
    }

    public function notice($message, array $context = [])
    {
        $this->lines[] = $message;
    }

    public function info($message, array $context = [])
    {
        $this->lines[] = $message;
    }

    public function debug($message, array $context = [])
    {
        $this->lines[] = $message;
    }

    public function log($level, $message, array $context = [])
    {
        $this->lines[] = $message;
    }

    public function getLinesAsString(): string
    {
        return implode(PHP_EOL, $this->lines);
    }
}
