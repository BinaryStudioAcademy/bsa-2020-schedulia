<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Exceptions\EventType\NameIsAlreadyInUseException;
use App\Exceptions\EventType\SlugIsAlreadyInUseException;
use App\Repositories\EventType\Criterion\NameCriterion;
use App\Repositories\EventType\Criterion\SlugCriterion;
use App\Repositories\EventType\EventTypeRepositoryInterface;

final class CloneEventTypeByIdAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;

    public function __construct(EventTypeRepositoryInterface $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute(CloneEventTypeByIdRequest $request): CloneEventTypeByIdResponse
    {
        $eventType = $this->eventTypeRepository->getById($request->getId());
        $newEventType = $eventType->replicate();

        $newSlug = $newEventType->slug . '-clone';
        $newName = $newEventType->name . ' (clone)';

        if (count($this->eventTypeRepository->findByCriteria(new SlugCriterion($newSlug)))) {
            throw new SlugIsAlreadyInUseException();
        }

        if (count($this->eventTypeRepository->findByCriteria(new NameCriterion($newName)))) {
            throw new NameIsAlreadyInUseException();
        }

        if (mb_strlen($newName) <= 50) {
            $newEventType->name = $newName;
        }
        $newEventType->slug = $newSlug;
        $newEventType->push();
        $newEventType->customFields()->createMany($eventType->customFields->toArray());
        $newEventType->availabilities()->createMany($eventType->availabilities->toArray());
//        $newEventType->tags()->createMany($eventType->tags->toArray());
        return new CloneEventTypeByIdResponse($newEventType);
    }
}
