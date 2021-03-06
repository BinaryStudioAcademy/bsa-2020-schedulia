<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Exceptions\EventType\NameIsAlreadyInUseException;
use App\Exceptions\EventType\SlugIsAlreadyInUseException;
use App\Repositories\EventType\Criterion\NameCriterion;
use App\Repositories\EventType\Criterion\SlugCriterion;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use Illuminate\Support\Str;

final class CloneEventTypeByIdAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;
    private const MAX_NAME_LENGTH = 50;

    public function __construct(EventTypeRepositoryInterface $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute(CloneEventTypeByIdRequest $request): CloneEventTypeByIdResponse
    {
        $eventType = $this->eventTypeRepository->getById($request->getId());
        $newEventType = $eventType->replicate();

        $newSlug = $newEventType->slug . '-copy' . Str::random(2);
        $newName = $newEventType->name . ' (copy)';

        if (count($this->eventTypeRepository->findByCriteria(new SlugCriterion($newSlug)))) {
            throw new SlugIsAlreadyInUseException();
        }

        if (count($this->eventTypeRepository->findByCriteria(new NameCriterion($newName)))) {
            throw new NameIsAlreadyInUseException();
        }

        if (mb_strlen($newName) <= self::MAX_NAME_LENGTH) {
            $newEventType->name = $newName;
        }
        $newEventType->slug = $newSlug;
        $newEventType->push();
        $newEventType->customFields()->createMany($eventType->customFields->toArray());
        $newEventType->availabilities()->createMany($eventType->availabilities->toArray());
        return new CloneEventTypeByIdResponse($newEventType);
    }
}
