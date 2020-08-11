<?php

declare(strict_types=1);

namespace App\Actions\Event;

use App\Entity\Event;
use App\Repositories\Event\EventRepository;
use App\Repositories\Event\EventRepositoryInterface;

final class AddEventAction
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(AddEventRequest $request): AddEventResponse
    {
        $event = new Event();

        $event->event_type_id = $request->getEventTypeId();
        $event->invitee_name = $request->getInviteeName();
        $event->invitee_email = $request->getInviteeEmail();
        $event->start_date = $request->getStartDate();
        $event->timezone = $request->getTimezone();

        $this->eventRepository->save($event);

        return new AddEventResponse();
    }
}
