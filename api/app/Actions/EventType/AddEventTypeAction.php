<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Contracts\AvailabilityServiceInterface;
use App\Entity\EventType;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use App\Services\Availability\AvailabilityService;
use Illuminate\Support\Facades\Auth;

final class AddEventTypeAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;
    private AvailabilityServiceInterface $availabilityService;

    public function __construct(
        EventTypeRepositoryInterface $eventTypeRepository,
        AvailabilityService $availabilityService
    ) {
        $this->eventTypeRepository = $eventTypeRepository;
        $this->availabilityService = $availabilityService;
    }

    public function execute(AddEventTypeRequest $request): AddEventTypeResponse
    {
        $eventType = new EventType();
        $eventType->name = $request->getName();
        $eventType->owner_id = Auth::id();
        $eventType->description = $request->getDescription();
        $eventType->slug = $request->getSlug();
        $eventType->color = $request->getColor();
        $eventType->duration = $request->getDuration();
        $eventType->timezone = $request->getTimezone();
        $eventType->disabled = $request->getDisabled();

        if ($this->availabilityService->validateAvailabilities($request->getAvailabilities())) {
            $eventType = $this->eventTypeRepository->save($eventType);
            $this->eventTypeRepository->saveAvailabilities($eventType, $request->getAvailabilities());
        }

        return new AddEventTypeResponse($eventType);
    }
}
