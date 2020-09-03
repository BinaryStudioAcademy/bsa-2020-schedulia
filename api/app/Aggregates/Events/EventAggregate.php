<?php

declare(strict_types=1);

namespace App\Aggregates\Events;

use App\Entity\Event;
use Carbon\Carbon;

class EventAggregate
{
    private int $id;
    private string $inviteeEmail;
    private string $startDate;
    private int $eventType;

    public function __construct(Event $event)
    {
        $this->id = $event->id;
        $this->inviteeEmail = $event->invitee_email;
        $this->startDate = $event->start_date;
        $this->eventType = $event->eventType;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'invitee_email' => $this->inviteeEmail,
            'start_date' => $this->startDate,
            'event_type' => $this->eventType,
        ];
    }
}
