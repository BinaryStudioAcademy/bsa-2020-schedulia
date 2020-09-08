<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Events\EventTypeDeleted;
use App\Exceptions\EventTypeNotFoundException;
use App\Jobs\SendNotificationWhenEventTypeDeleted;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

final class DeleteEventTypeAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;

    public function __construct(EventTypeRepositoryInterface $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute(DeleteEventTypeRequest $request): void
    {
        $eventType = $this->eventTypeRepository->getById($request->getId());

        if (is_null($eventType)) {
            throw new EventTypeNotFoundException('Event Type not found.', 404);
        }

        if ($eventType->owner_id !== Auth::id()) {
            throw new AuthorizationException();
        }

        $eventTypeName = $eventType->name;
        $eventTypeOwner = $eventType->owner;
        $eventTypeEvents = $eventType->events->map(function ($event) use ($eventTypeName){
            return [
                'invitee_email' => $event->invitee_email,
                'invitee_name' => $event->invitee_name,
                'start_date' => $event->start_date,
                'event_type_name' => $eventTypeName
            ];
        })->toArray();

        SendNotificationWhenEventTypeDeleted::dispatch($eventTypeName, $eventTypeOwner, $eventTypeEvents);

        $eventType->events()->delete();
        $eventType->customFields()->delete();
        $this->eventTypeRepository->deleteById($eventType->id);
    }
}
