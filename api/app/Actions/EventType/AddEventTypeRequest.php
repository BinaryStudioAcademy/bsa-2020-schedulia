<?php

declare(strict_types=1);

namespace App\Actions\EventType;

final class AddEventTypeRequest
{
    private $name;
    private $description;
    private $slug;
    private $color;
    private $duration;
    private $timezone;
    private $disabled;

    public function __construct(
        string $name,
        ?string $description,
        string $slug,
        string $color,
        int $duration,
        string $timezone,
        int $disabled
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->slug = $slug;
        $this->color = $color;
        $this->duration = $duration;
        $this->timezone = $timezone;
        $this->disabled = $disabled;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function getDisabled(): int
    {
        return $this->disabled;
    }
}
