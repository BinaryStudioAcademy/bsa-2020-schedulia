<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Exceptions\EventTypeNotFoundException;
use App\Repositories\EventType\EventTypeRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

final class DeleteEventTypeAction
{
    private EventTypeRepository $eventTypeRepository;

    public function __construct(EventTypeRepository $eventTypeRepository)
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

        $this->eventTypeRepository->deleteById($eventType->id);
    }
}
