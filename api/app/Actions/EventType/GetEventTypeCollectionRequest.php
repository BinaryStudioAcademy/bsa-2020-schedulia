<?php

declare(strict_types=1);

namespace App\Actions\EventType;

final class GetEventTypeCollectionRequest
{
    private ?string $searchString;

    public function __construct(?string $searchString)
    {
        $this->searchString = $searchString ? mb_strtolower($searchString) : '';
    }

    public function getSearchString(): ?string
    {
        return $this->searchString;
    }
}
