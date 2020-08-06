<?php

declare(strict_types = 1);

namespace App\Actions\EventType;

use App\Exceptions\EventTypeNotFoundException;
use App\Repositories\EventType\EventTypeRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

final class UpdateEventTypeAction
{
    private $eventTypeRepository;

    public function __construct(EventTypeRepository $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute(UpdateEventTypeRequest $request): UpdateEventTypeResponse
    {
        try {
            $eventType = $this->eventTypeRepository->getById($request->getId());
        } catch (ModelNotFoundException $ex) {
            throw new EventTypeNotFoundException('User not found.', 404);
        }

        if ($eventType->owner_id !== Auth::id()) {
            throw new AuthorizationException();
        }

        $eventType->name = $request->getName() ?: $eventType->email;
        $eventType->description = $request->getDescription() ?: $eventType->description;
        $eventType->slug = $request->getSlug() ?: $eventType->slug;
        $eventType->color = $request->getColor() ?: $eventType->color;
        $eventType->duration = $request->getDuration() ?: $eventType->duration;
        $eventType->timezone = $request->getTimezone() ?: $eventType->timezone;
        $eventType->disabled = $request->getDisabled() ?: $eventType->disabled;

        $eventType = $this->eventTypeRepository->save($eventType);

        return new UpdateEventTypeResponse($eventType);
    }
}
