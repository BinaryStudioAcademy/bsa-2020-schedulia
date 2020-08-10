<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Actions\GetByIdRequest;
use App\Exceptions\EventTypeNotFoundException;
use App\Repositories\EventType\EventTypeRepositoryInterface;

final class GetEventTypeByIdAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;

    public function __construct(EventTypeRepositoryInterface $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute(GetByIdRequest $request): GetEventTypeByIdResponse
    {
        $eventType = $this->eventTypeRepository->getById($request->getId());

        if (is_null($eventType)) {
            throw new EventTypeNotFoundException('Event Type not found.', 404);
        }

        return new GetEventTypeByIdResponse($eventType);
    }
}
