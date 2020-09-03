<?php

namespace App\Actions\Event;

use App\Entity\Event;

class UpdateEventResponse
{
    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }
}
