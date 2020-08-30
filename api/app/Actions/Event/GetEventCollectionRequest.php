<?php

declare(strict_types=1);

namespace App\Actions\Event;

final class GetEventCollectionRequest
{
    private ?string $startDate;
    private ?string $endDate;
    private ?array $eventTypes;
    private ?array $eventEmails;
    private ?int $page;
    private ?int $perPage;
    private ?string $sort;
    private ?string $direction;

    public function __construct(
        ?string $startDate,
        ?string $endDate,
        ?array $eventTypes,
        ?array $eventEmails,
        ?int $page,
        ?int $perPage,
        ?string $sort,
        ?string $direction
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->eventTypes = $eventTypes;
        $this->eventEmails = $eventEmails;
        $this->page = $page;
        $this->perPage = $perPage;
        $this->sort = $sort;
        $this->direction = $direction;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function getEventTypes(): ?array
    {
        return $this->eventTypes;
    }

    public function getEventEmails(): ?array
    {
        return $this->eventEmails;
    }
}
