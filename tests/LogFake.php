<?php

namespace Spatie\LogDumper\Tests;

use Psr\Log\LoggerInterface;

class LogFake implements LoggerInterface
{
    public array $lines = [];

    public function emergency($message, array $context = [])
    {
        $this->lines['emergency'][] = $message;
    }

    public function alert($message, array $context = [])
    {
        $this->lines['alerts'][] = $message;
    }

    public function critical($message, array $context = [])
    {
        $this->lines['critical'][] = $message;
    }

    public function error($message, array $context = [])
    {
        $this->lines['error'][] = $message;
    }

    public function warning($message, array $context = [])
    {
        $this->lines['warning'][] = $message;
    }

    public function notice($message, array $context = [])
    {
        $this->lines['notice'][] = $message;
    }

    public function info($message, array $context = [])
    {
        $this->lines['info'][] = $message;
    }

    public function debug($message, array $context = [])
    {
        $this->lines['debug'][] = $message;
    }

    public function log($level, $message, array $context = [])
    {
        $this->lines[$level][] = $message;
    }

    public function getLinesAsString(): string
    {
        return print_r($this->lines, true);
    }
}
