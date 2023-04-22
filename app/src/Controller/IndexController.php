<?php

namespace App\Controller;

use App\Service\ServerSentEventManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController
{
    const EVENT_COUNT = 10;

    #[Route("/api/v1/sse_example", methods: ['GET'])]
    public function serverSentEventAction(): Response
    {
        return ServerSentEventManager::getStreamResponse(function () {
            $sentEvent = 0;
            do {
                ServerSentEventManager::send('example_event', ['eventId' => $sentEvent]);
                $sentEvent++;
                sleep(1);
            } while ($sentEvent <= self::EVENT_COUNT);
        });
    }
}