<?php

declare(strict_types=1);

namespace App\Actions\EventType;

final class AddEventTypeRequest
{
    private string $name;
    private ?string $description;
    private string $slug;
    private string $color;
    private int $duration;
    private string $timezone;
    private bool $disabled;
    private array $availabilities;
    private string $locationType;
    private ?array $coordinates;

    public function __construct(
        string $name,
        ?string $description,
        string $slug,
        string $color,
        int $duration,
        string $timezone,
        bool $disabled,
        array $availabilities,
        string $locationType,
        ?array $coordinates
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->slug = $slug;
        $this->color = $color;
        $this->duration = $duration;
        $this->timezone = $timezone;
        $this->disabled = $disabled;
        $this->availabilities = $availabilities;
        $this->locationType = $locationType;
        $this->coordinates = $coordinates;
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

    public function getDisabled(): bool
    {
        return $this->disabled;
    }

    public function getAvailabilities(): array
    {
        return $this->availabilities;
    }

    public function getLocationType(): string
    {
        return $this->locationType;
    }

    public function getCoordinates(): ?array
    {
        return $this->coordinates;
    }
}
