<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Entity\EventType;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use Illuminate\Support\Facades\Auth;

final class AddEventTypeAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;

    public function __construct(EventTypeRepositoryInterface $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
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

        $eventType = $this->eventTypeRepository->save($eventType);

        return new AddEventTypeResponse($eventType);
    }
}
