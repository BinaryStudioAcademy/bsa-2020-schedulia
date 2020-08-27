<?php

declare(strict_types=1);

namespace App\Actions\Event;

final class AddEventRequest
{
    private int $eventTypeId;
    private string $inviteeName;
    private string $inviteeEmail;
    private string $startDate;
    private string $timezone;
    private array $customFieldValues;

    public function __construct(
        int $eventTypeId,
        string $inviteeName,
        string $inviteeEmail,
        string $startDate,
        string $timezone,
        array $customFieldValues
    ) {
        $this->eventTypeId = $eventTypeId;
        $this->inviteeName = $inviteeName;
        $this->inviteeEmail = $inviteeEmail;
        $this->startDate = $startDate;
        $this->timezone = $timezone;
        $this->customFieldValues = $customFieldValues;
    }

    public function getEventTypeId(): int
    {
        return $this->eventTypeId;
    }

    public function getInviteeName(): string
    {
        return $this->inviteeName;
    }

    public function getInviteeEmail(): string
    {
        return $this->inviteeEmail;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function getCustomFieldValues(): array
    {
        return $this->customFieldValues;
    }
}
