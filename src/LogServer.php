<?php

namespace Spatie\LogDumper;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LogServer
{
    protected $endpoint = 'http://localhost:3000';

    public function clearScreen(): self
    {
        $this->call(['type' => 'clear_screen']);

        return $this;
    }

    public function log($content, array $style)
    {
        $payload = compact('content', 'style');

        $payload['type'] = 'log';

        $this->call($payload);

        return $this;
    }

    protected function call(array $payload)
    {
        $frameInfo = [
            'timestamp' => now()->timestamp,
            'file' => $this->getFrame()['file'] ?? null,
            'line_number' => $this->getFrame()['line'] ?? null,
        ];

        $payload = array_merge($frameInfo, $payload);

        Http::post($this->endpoint, $payload);
    }

    protected function getFrame(): ?array
    {
        $trace = array_reverse(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));

        $ldIndex = $this->getIndexOfLdCall($trace);

        if (! $ldIndex) {
            return null;
        }


        $frameIndex = $ldIndex - 1;

        return $trace[$frameIndex] ?? null;
    }

    protected function getIndexOfLdCall(array $stackTrace): ?int
    {

        foreach($stackTrace as $index => $frame) {
            if ((Str::startsWith($frame['file'], __DIR__))) {
                return $index;
            }
        }

        return null;
    }
}
