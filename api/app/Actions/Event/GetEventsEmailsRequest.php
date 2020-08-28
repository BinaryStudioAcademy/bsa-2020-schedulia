<?php

declare(strict_types=1);

namespace App\Actions\Event;

final class GetEventsEmailsRequest
{
    private ?string $startDate;
    private ?string $endDate;

    public function __construct(
        ?string $startDate,
        ?string $endDate
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
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
