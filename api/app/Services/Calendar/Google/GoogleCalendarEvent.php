<?php

declare(strict_types=1);

namespace App\Services\Calendar\Google;

use App\Contracts\CalendarEventInterface;
use Carbon\Carbon;

final class GoogleCalendarEvent implements CalendarEventInterface
{
    private int $userId;
    private string $summary;
    private ?string $location;
    private $startTime;
    private int $duration;
    private ?string $description;
    private string $attendeeEmail;
    private string $color;

    public function __construct(
        int $userId,
        string $summary,
        $startTime,
        $duration,
        ?string $descritpion = null,
        string $color,
        string $attendeeEmail,
        ?string $location = null
    ) {
        $this->userId = $userId;
        $this->startTime = $startTime;
        $this->duration = $duration;
        $this->color = $color;
        $this->atendeeEmail = $attendeeEmail;
        $this->summary = $summary;
        $this->location = $location;
        $this->description = $descritpion;
    }

    private function getDefaultColor(): int
    {
        return GoogleCalendarColors::GOOGLE_EVENT_COLOR_BOLD_GREEN;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getStartTime(): string
    {
        return Carbon::parse($this->startTime)->toRfc3339String();
    }

    public function getEndTime(): string
    {
        return Carbon::parse($this->startTime)->addMinutes($this->duration)->toRfc3339String();
    }

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function getAttendeeEmail(): string
    {
        return $this->atendeeEmail;
    }

    public function getColorAccordingGoogle(): int
    {
        return GoogleCalendarColors::getColors()[$this->color] ?? $this->getDefaultColor();
    }

    public function getColorByName($name): int
    {
        return GoogleCalendarColors::getColors()[$name] ?? $this->getDefaultColor();
    }
}
