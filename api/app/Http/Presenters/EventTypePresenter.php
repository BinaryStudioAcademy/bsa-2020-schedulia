<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Entity\EventType;
use Illuminate\Support\Collection;

final class EventTypePresenter
{
    private UserArrayPresenter $userPresenter;

    public function __construct(UserArrayPresenter $userPresenter)
    {
        $this->userPresenter = $userPresenter;
    }

    public function presentCollection(Collection $eventTypeCollection): array
    {
        return $eventTypeCollection->map(function ($eventType) {
            return $this->present($eventType);
        })->toArray();
    }

    public function present(EventType $eventType): array
    {
        return [
            'id' => $eventType->id,
            'name' => $eventType->name,
            'description' => $eventType->description,
            'slug' => $eventType->slug,
            'color' => $eventType->color,
            'duration' => $eventType->duration,
            'disabled' => $eventType->disabled,
            'timezone' => $eventType->timezone,
            'owner' => $this->userPresenter->present($eventType->owner),
        ];
    }
}
