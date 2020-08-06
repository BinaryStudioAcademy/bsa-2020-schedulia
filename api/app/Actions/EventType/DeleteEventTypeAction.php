<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Exceptions\EventTypeNotFoundException;
use App\Repositories\EventType\EventTypeRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

final class DeleteEventTypeAction
{
    private $eventTypeRepository;

    public function __construct(EventTypeRepository $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute(DeleteEventTypeRequest $request): void
    {
        try {
            $eventType = $this->eventTypeRepository->getById($request->getId());
        } catch (ModelNotFoundException $ex) {
            throw new EventTypeNotFoundException();
        }

        if ($eventType->owner_id !== Auth::id()) {
            throw new AuthorizationException();
        }

        $this->eventTypeRepository->delete($eventType);
    }
}
