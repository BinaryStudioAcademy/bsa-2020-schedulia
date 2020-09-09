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
    private ?array $customFieldValues;
    private ?string $inviteeInformation;

    public function __construct(
        int $eventTypeId,
        string $inviteeName,
        string $inviteeEmail,
        string $startDate,
        string $timezone,
        ?array $customFieldValues,
        ?string $inviteeInformation
    ) {
        $this->eventTypeId = $eventTypeId;
        $this->inviteeName = $inviteeName;
        $this->inviteeEmail = $inviteeEmail;
        $this->startDate = $startDate;
        $this->timezone = $timezone;
        $this->customFieldValues = $customFieldValues;
        $this->inviteeInformation = $inviteeInformation;
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

    public function getCustomFieldValues(): ?array
    {
        return $this->customFieldValues;
    }

    public function getInviteeInformation(): ?string
    {
        return $this->inviteeInformation;
    }
}
