<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Contracts\PresenterCollectionInterface;
use App\Entity\Event;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class EventPresenter implements PresenterCollectionInterface
{
    private EventTypePresenter $eventTypePresenter;

    public function __construct(
        EventTypePresenter $eventTypePresenter
    )
    {
        $this->eventTypePresenter = $eventTypePresenter;
    }

    public function present(Event $event): array
    {
        return [
            'id' => $event->id,
            'invitee_name' => $event->invitee_name,
            'invitee_email' => $event->invitee_email,
            'invitee_question' => 'No questions',
            'start_date' => $event->start_date,
            'location' => $event->location,
            'timezone' => $event->timezone,
            'created_at' => Carbon::parse($event->created_at)->format('d.m.Y'),
            'event_type' => $this->eventTypePresenter->present($event->eventType),
        ];
    }

    public function presentCollection(Collection $eventCollection): array
    {
        return $eventCollection->map(function ($event) {
            return $this->present($event);
        })->toArray();
    }
}
