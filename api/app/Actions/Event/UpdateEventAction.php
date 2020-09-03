<?php

declare(strict_types=1);

namespace App\Actions\Event;

use App\Constants\EventStatus;
use App\Events\EventUpdated;

use App\Repositories\Event\EventRepositoryInterface;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use App\Services\Availability\AvailabilityService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class UpdateEventAction
{
    private EventRepositoryInterface $eventRepository;
    private EventTypeRepositoryInterface $eventTypeRepository;
    private AvailabilityService $availabilityService;

    public function __construct(
        EventRepositoryInterface $eventRepository,
        EventTypeRepositoryInterface $eventTypeRepository,
        AvailabilityService $availabilityService
    ) {
        $this->eventRepository = $eventRepository;
        $this->eventTypeRepository = $eventTypeRepository;
        $this->availabilityService = $availabilityService;
    }

    public function execute(UpdateEventRequest $request): UpdateEventResponse
    {
        $event = $this->eventRepository->getById($request->getEventId());

        if (!$event) {
            throw new ModelNotFoundException('Event not found');
        }

        if ($event->eventType->owner->id !== $request->getUserId()) {
            throw new AuthorizationException();
        }

        $eventType = $this->eventTypeRepository->getById($request->getEventTypeId());

        if ($request->getStatus() == EventStatus::CANCELLED
            || $this->availabilityService->checkIfTimeIsAvailable($eventType, $request->getStartDate())
        ) {
            $event->event_type_id = $request->getEventTypeId();
            $event->invitee_name = $request->getInviteeName();
            $event->invitee_email = $request->getInviteeEmail();
            $event->start_date = $request->getStartDate();
            $event->timezone = $request->getTimezone();
            $event->location = $request->getLocation();
            $event->status = $request->getStatus();

            $this->eventRepository->save($event);

            if ($request->getCustomFieldValues()) {
                $this->eventRepository->saveCustomFieldValues($event, $request->getCustomFieldValues());
            }

            event(new EventUpdated($event));

            return new UpdateEventResponse($event);
        }
    }
}
