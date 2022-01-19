<?php

namespace Spatie\LogDumper\Tests;

use Psr\Log\LoggerInterface;

class LogFake implements LoggerInterface
{
    public array $lines = [];

    public function emergency($message, array $context = []): void
    {
        $this->lines['emergency'][] = $message;
    }

    public function alert($message, array $context = []): void
    {
        $this->lines['alerts'][] = $message;
    }

    public function critical($message, array $context = []): void
    {
        $this->lines['critical'][] = $message;
    }

    public function error($message, array $context = []): void
    {
        $this->lines['error'][] = $message;
    }

    public function warning($message, array $context = []): void
    {
        $this->lines['warning'][] = $message;
    }

    public function notice($message, array $context = []): void
    {
        $this->lines['notice'][] = $message;
    }

    public function info($message, array $context = []): void
    {
        $this->lines['info'][] = $message;
    }

    public function debug($message, array $context = []): void
    {
        $this->lines['debug'][] = $message;
    }

    public function log($level, $message, array $context = []): void
    {
        $this->lines[$level][] = $message;
    }

    public function getLines(): array
    {
        return $this->lines;
    }

    public function getLinesAsString(): string
    {
        return print_r($this->lines, true);
    }
}
