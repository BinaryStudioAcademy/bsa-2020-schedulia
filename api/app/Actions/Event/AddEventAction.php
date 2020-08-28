<?php

declare(strict_types=1);

namespace App\Actions\Event;

use App\Entity\Event;
use App\Events\EventCreated;
use App\Exceptions\Availability\TimeIsAlreadyBookedException;
use App\Exceptions\Availability\WrongDateTimeException;
use App\Repositories\Event\EventRepository;
use App\Repositories\Event\EventRepositoryInterface;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use App\Services\Availability\AvailabilityService;

final class AddEventAction
{
    private EventRepositoryInterface $eventRepository;
    private EventTypeRepositoryInterface $eventTypeRepository;
    private AvailabilityService $availabilityService;

    public function __construct(
        EventRepository $eventRepository,
        EventTypeRepositoryInterface $eventTypeRepository,
        AvailabilityService $availabilityService
    ) {
        $this->eventRepository = $eventRepository;
        $this->eventTypeRepository = $eventTypeRepository;
        $this->availabilityService = $availabilityService;
    }

    public function execute(AddEventRequest $request): void
    {
        $eventType = $this->eventTypeRepository->getById($request->getEventTypeId());
        if ($this->availabilityService->checkIfTimeIsAvailable($eventType, $request->getStartDate())) {
            $event = new Event();

            $event->event_type_id = $request->getEventTypeId();
            $event->invitee_name = $request->getInviteeName();
            $event->invitee_email = $request->getInviteeEmail();
            $event->start_date = $request->getStartDate();
            $event->timezone = $request->getTimezone();

            $this->eventRepository->save($event);
            if ($request->getCustomFieldValues()) {
                $this->eventRepository->saveCustomFieldValues($event, $request->getCustomFieldValues());
            }

            event(new EventCreated($event));
        }
    }
}
