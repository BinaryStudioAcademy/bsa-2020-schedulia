<?php

declare(strict_types=1);

namespace App\Actions\EventType;

final class GetAvailableTimeResponse
{
    private array $dateTimeList;

    public function __construct(array $dateTimeList)
    {
        $this->dateTimeList = $dateTimeList;
    }

    public function getDateTimeList(): array
    {
        return $this->dateTimeList;
    }
}
