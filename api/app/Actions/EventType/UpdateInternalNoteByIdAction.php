<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Repositories\EventType\EventTypeRepositoryInterface;

final class UpdateInternalNoteByIdAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;

    public function __construct(EventTypeRepositoryInterface $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute(UpdateInternalNoteByIdRequest $request): void
    {
        $eventType = $this->eventTypeRepository->getById($request->getId());
        $eventType->internal_note = $request->getInternalNote();
        $eventType->save();
    }
}
