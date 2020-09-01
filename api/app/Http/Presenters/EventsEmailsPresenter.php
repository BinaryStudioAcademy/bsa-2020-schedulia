<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Contracts\PresenterCollectionInterface;
use App\Entity\Event;
use Illuminate\Support\Collection;

final class EventsEmailsPresenter implements PresenterCollectionInterface
{
    public function present(Event $event): array
    {
        return [
            'email' => $event->invitee_email,
        ];
    }

    public function presentCollection(Collection $eventCollection): array
    {
        return $eventCollection->map(function ($event) {
            return $this->present($event);
        })->toArray();
    }
}
