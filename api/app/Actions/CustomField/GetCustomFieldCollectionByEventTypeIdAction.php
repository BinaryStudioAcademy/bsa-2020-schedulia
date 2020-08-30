<?php

declare(strict_types=1);

namespace App\Actions\CustomField;

use App\Repositories\EventType\EventTypeRepositoryInterface;

final class GetCustomFieldCollectionByEventTypeIdAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;

    public function __construct(EventTypeRepositoryInterface $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute(GetCustomFieldCollectionByEventTypeIdRequest $request): GetCustomFieldCollectionByEventTypeIdResponse
    {
        $eventType = $this->eventTypeRepository->getById($request->getEventTypeId());

        return new GetCustomFieldCollectionByEventTypeIdResponse($eventType->customFields);
    }
}
