<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Repositories\EventType\EventTypeRepositoryInterface;
use App\Services\Availability\AvailabilityService;

final class GetAvailableTimeAction
{
    private EventTypeRepositoryInterface $eventRepository;
    private AvailabilityService $availabilityService;

    public function __construct(
        EventTypeRepositoryInterface $eventRepository,
        AvailabilityService $availabilityService
    ) {
        $this->eventRepository = $eventRepository;
        $this->availabilityService = $availabilityService;
    }

    public function execute(GetAvailableTimeRequest $request): GetAvailableTimeResponse
    {
        $eventType = $this->eventRepository->getById($request->getEventTypeId());

        $dateTimeList = $this->availabilityService->getAvailableDaysByEventType(
            $eventType,
            $request->getMonth()
        );

        return new GetAvailableTimeResponse($dateTimeList);
    }
}
