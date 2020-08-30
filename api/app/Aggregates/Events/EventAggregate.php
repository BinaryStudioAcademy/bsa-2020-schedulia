<?php

declare(strict_types=1);

namespace App\Aggregates\Events;

use App\Entity\Event;

class EventAggregate
{
    private Event $event;

    public function __construct(Event $event)
    {
		$this->event = $event;
	}

    public function getId(): int
    {
        return $this->event->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'invitee_email' => $this->event->invitee_email,
            'start_date' => $this->event->start_date,
            'event_type' => $this->event->event_type_id,
        ];
    }
}
