<?php

declare(strict_types=1);

namespace App\Services\Calendar\Google;

use App\Contracts\CalendarEvent;
use Carbon\Carbon;

final class GoogleCalendarEvent implements CalendarEvent
{
    private string $summary;
    private ?string $location;
    private $startTime;
    private int $duration;
    private ?string $description;

    public function __construct(
        string $summary,
        $startTime,
        $duration,
        ?string $descritpion = null,
        ?string $location = null
    ) {
        $this->startTime = $startTime;
        $this->duration = $duration;
        $this->summary = $summary;
        $this->location = $location;
        $this->description = $descritpion;
    }

    public function getStartTime()
    {
        return Carbon::parse($this->startTime)->toIso8601String();
    }

    public function getEndTime()
    {
        return Carbon::parse($this->startTime)->addMinutes($this->duration)->toIso8601String();
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
}
