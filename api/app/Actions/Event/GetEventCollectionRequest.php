<?php

declare(strict_types=1);

namespace App\Actions\Event;

final class GetEventCollectionRequest
{
    private ?string $startDate;
    private ?string $endDate;
    private ?int $page;
    private ?int $perPage;
    private ?string $sort;
    private ?string $direction;

    public function __construct(
        ?string $startDate,
        ?string $endDate,
        ?int $page,
        ?int $perPage,
        ?string $sort,
        ?string $direction
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
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
}
