<?php

namespace Spatie\LogDumper;

use Illuminate\Support\Facades\Http;

class LogServer
{
    protected $endpoint = 'http://log-listener.test/api/log';

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
            'file' => $this->getFrame()['file'] ?? null,
            'line_number' => $this->getFrame()['line'] ?? null,
        ];

        $payload = array_merge($frameInfo, $payload);

        Http::withoutVerifying()->post($this->endpoint, $payload);
    }

    protected function getFrame(): ?array
    {
        return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 6)[5] ?? null;
    }
}
