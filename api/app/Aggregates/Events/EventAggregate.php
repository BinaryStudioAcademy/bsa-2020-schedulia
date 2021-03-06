<?php

declare(strict_types=1);

namespace App\Aggregates\Events;

use App\Entity\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class EventAggregate
{
    private int $id;
    private string $inviteeEmail;
    private string $inviteeName;
    private string $timezone;
    private ?string $location;
    private $createdAt;
    private string $status;
    private ?string $inviteeInformation;
    private int $startDate;
    private int $eventTypeId;
    private int $eventTypeOwnerId;
    private ?Collection $eventTypeTagsId;

    public function __construct(Event $event)
    {
        $this->id = $event->id;
        $this->inviteeEmail = $event->invitee_email;
        $this->inviteeName = $event->invitee_name;
        $this->timezone = $event->timezone;
        $this->location = $event->location;
        $this->createdAt = $event->created_at;
        $this->status = $event->status;
        $this->inviteeInformation = $event->invitee_information;
        $this->startDate = Carbon::parse($event->start_date)->timestamp;
        $this->eventTypeId = $event->event_type_id;
        $this->eventTypeOwnerId = $event->eventType ? $event->eventType->owner_id : null;
        $this->eventTypeTagsId = $event->eventType ? $event->eventType->tags : null;
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
            'invitee_name' => $this->inviteeName,
            'timezone' => $this->timezone,
            'location' => $this->location,
            'created_at' => $this->createdAt,
            'status' => $this->status,
            'invitee_information' => $this->inviteeInformation,
            'start_date' => $this->startDate,
            'event_type_id' => $this->eventTypeId,
            'event_type_owner_id' => $this->eventTypeOwnerId,
            'event_type_tags' => $this->eventTypeTagsId
        ];
    }
}
