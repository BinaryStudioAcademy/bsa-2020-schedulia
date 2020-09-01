<?php

declare(strict_types=1);

namespace App\Actions\Event;

use App\Events\EventDeleted;
use App\Http\Presenters\EventPresenter;
use App\Repositories\Event\EventRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class DeleteEventAction
{
    private EventRepositoryInterface $eventRepository;
    private EventPresenter $eventPresenter;

    public function __construct(
        EventRepositoryInterface $eventRepository,
        EventPresenter $eventPresenter

    ) {
        $this->eventRepository = $eventRepository;
        $this->eventPresenter = $eventPresenter;
    }

    public function execute(DeleteEventRequest $request): void
    {
        $event = $this->eventRepository->getById($request->getId());

        if(!$event) {
            throw new ModelNotFoundException('Event not found');
        }

        if ($event->eventType->owner->id !== $request->getUserId()) {
            throw new AuthorizationException();
        }

        $deletedEvent = $this->eventPresenter->present($event);
        $this->eventRepository->deleteById($event->id);

        event(new EventDeleted($deletedEvent));
    }
}
