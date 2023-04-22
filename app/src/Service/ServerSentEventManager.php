<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ServerSentEventManager
{
    public static function send($eventName, array $data): void
    {
        echo "event: $eventName" . PHP_EOL;
        echo sprintf('data: %s' . PHP_EOL, json_encode($data));
        echo PHP_EOL . PHP_EOL;
        @ob_flush();
        @flush();
    }

    public static function getStreamResponse(callable $callback): ?StreamedResponse
    {
        // Removing execution time limit
        ini_set('max_execution_time', 0);
        ignore_user_abort(true);

        // Saving session for provide access to read another processes
        session_write_close();
        $headers = [
            'Cache-Control' => 'no-cache',
            'Content-Type' => 'text/event-stream',
            'Access-Control-Allow-Origin' => '*',
            'X-Accel-Buffering' => 'no',

        ];
        return new StreamedResponse($callback, Response::HTTP_OK, $headers);
    }
}