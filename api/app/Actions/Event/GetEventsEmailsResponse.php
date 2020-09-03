<?php

declare(strict_types=1);

namespace App\Actions\Event;

use Illuminate\Support\Collection;

final class GetEventsEmailsResponse
{
    private Collection $event;

    public function __construct(Collection $event)
    {
        $this->event = $event;
    }

    public function getEvent(): Collection
    {
        return $this->event;
    }
}
