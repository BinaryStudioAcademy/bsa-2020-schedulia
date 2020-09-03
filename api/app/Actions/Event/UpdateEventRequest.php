<?php

declare(strict_types=1);

namespace App\Actions\Event;

use App\Constants\EventStatus;

final class UpdateEventRequest
{
    private int $id;
    private int $userId;
    private ?int $eventTypeId;
    private ?string $inviteeName;
    private ?string $inviteeEmail;
    private ?string $startDate;
    private ?string $timezone;
    private ?string $location;
    private ?string $status;
    private ?array $customFieldValues;

    public function __construct(
        int $id,
        int $userId,
        ?int $eventTypeId,
        ?string $inviteeName,
        ?string $inviteeEmail,
        ?string $startDate,
        ?string $timezone,
        ?string $location,
        ?string $status,
        ?array $customFieldValues
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->eventTypeId = $eventTypeId;
        $this->inviteeName = $inviteeName;
        $this->inviteeEmail = $inviteeEmail;
        $this->startDate = $startDate;
        $this->location = $location;
        $this->status = $status;
        $this->timezone = $timezone;
        $this->customFieldValues = $customFieldValues;
    }

    public function getEventId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function getStatus(): ?string
    {
        return $this->status === 'cancelled' ? EventStatus::CANCELLED : EventStatus::SCHEDULED;
    }

    public function getEventTypeId(): ?int
    {
        return $this->eventTypeId;
    }

    public function getInviteeName(): ?string
    {
        return $this->inviteeName;
    }

    public function getInviteeEmail(): ?string
    {
        return $this->inviteeEmail;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function getCustomFieldValues(): ?array
    {
        return $this->customFieldValues;
    }
}
