<?php

declare(strict_types=1);

namespace App\Actions\Tag;

final class GetTagsByEventDateRangeRequest
{
    private ?string $searchString;
    private ?string $startDate;
    private ?string $endDate;

    public function __construct(
        ?string $searchString,
        ?string $startDate,
        ?string $endDate
    ) {
        $this->searchString = $searchString;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getSearchString(): ?string
    {
        return $this->searchString;
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
