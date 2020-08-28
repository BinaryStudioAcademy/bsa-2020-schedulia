<?php

declare(strict_types=1);

namespace App\Actions\AvailabilityService;

final class ModificateDateTimeListResponse
{
    private array $modifiedTimeList;

    public function __construct(array $modifiedTimeList)
    {
        $this->modifiedTimeList = $modifiedTimeList;
    }

    public function getModifiedTimeList(): array
    {
        return $this->modifiedTimeList;
    }
}
