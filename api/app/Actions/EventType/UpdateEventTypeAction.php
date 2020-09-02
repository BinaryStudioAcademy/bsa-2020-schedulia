<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Exceptions\EventType\CoordinatesFieldIsRequiredException;
use App\Exceptions\EventTypeNotFoundException;
use App\Http\Requests\Api\EventType\LocationTypes;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

final class UpdateEventTypeAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;

    public function __construct(EventTypeRepositoryInterface $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute(UpdateEventTypeRequest $request): UpdateEventTypeResponse
    {
        $eventType = $this->eventTypeRepository->getById($request->getId());

        if (is_null($eventType)) {
            throw new EventTypeNotFoundException('Event Type not found.', 404);
        }

        if ($eventType->owner_id !== Auth::id()) {
            throw new AuthorizationException();
        }

        $eventType->name = $request->getName() ?: $eventType->email;
        $eventType->description = $request->getDescription();
        $eventType->slug = $request->getSlug() ?: $eventType->slug;
        $eventType->color = $request->getColor() ?: $eventType->color;
        $eventType->duration = $request->getDuration() ?: $eventType->duration;
        $eventType->timezone = $request->getTimezone() ?: $eventType->timezone;
        $eventType->disabled = $request->getDisabled() ?: $eventType->disabled;
        $eventType->location_type = $request->getLocationType();

        if ($request->getLocationType() === LocationTypes::ADDRESS) {
            if ($request->getCoordinates()) {
                $eventType->coordinates = $request->getCoordinates();
            } else {
                throw new CoordinatesFieldIsRequiredException();
            }
        }

        $eventType = $this->eventTypeRepository->save($eventType);

        $this->eventTypeRepository->deleteAvailabilities($eventType);
        $this->eventTypeRepository->saveAvailabilities($eventType, $request->getAvailabilities());

        return new UpdateEventTypeResponse($eventType);
    }
}
