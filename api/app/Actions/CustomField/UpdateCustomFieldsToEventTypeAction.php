<?php

declare(strict_types=1);

namespace App\Actions\CustomField;

use App\Repositories\EventType\EventTypeRepositoryInterface;

final class UpdateCustomFieldsToEventTypeAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;

    public function __construct(EventTypeRepositoryInterface $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute(UpdateCustomFieldsToEventTypeRequest $request): void
    {
        $eventType = $this->eventTypeRepository->getById($request->getEventTypeId());

        $this->eventTypeRepository->deleteCustomFields($eventType);
        $this->eventTypeRepository->saveCustomFields($eventType, $request->getCustomFields());
    }
}
