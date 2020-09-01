<?php

declare(strict_types=1);

namespace App\Actions\Event;

final class GetEventsEmailsRequest
{
    private ?string $startDate;
    private ?string $endDate;
    private ?string $searchString;

    public function __construct(
        ?string $startDate,
        ?string $endDate,
        ?string $searchString
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->searchString = $searchString;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function getSearchString(): ?string
    {
        return $this->searchString;
    }
}
