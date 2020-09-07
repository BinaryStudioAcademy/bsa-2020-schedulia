<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Contracts\AvailabilityServiceInterface;
use App\Entity\Availability;
use App\Entity\EventType;
use App\Entity\Tag;
use App\Exceptions\EventType\CoordinatesFieldIsRequiredException;
use App\Http\Requests\Api\EventType\LocationTypes;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use App\Repositories\Tag\TagRepository;
use Illuminate\Support\Facades\Auth;

final class AddEventTypeAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;
    private AvailabilityServiceInterface $availabilityService;
    private TagRepository $tagRepository;

    public function __construct(
        EventTypeRepositoryInterface $eventTypeRepository,
        AvailabilityServiceInterface $availabilityService,
        TagRepository $tagRepository
    ) {
        $this->eventTypeRepository = $eventTypeRepository;
        $this->availabilityService = $availabilityService;
        $this->tagRepository = $tagRepository;
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
        $eventType->location_type = $request->getLocationType();
        $eventType->address = $request->getAddress();

        if (Auth::user()->chatito_active) {
            $eventType->chatito_workspace = $request->getChatitoWorkspace();
        }

        if ($request->getLocationType() === LocationTypes::ADDRESS) {
            if ($request->getCoordinates()) {
                $eventType->coordinates = $request->getCoordinates();
            } else {
                throw new CoordinatesFieldIsRequiredException();
            }
        }

        $availabilities = collect($request->getAvailabilities())->map(function ($availability) {
            return new Availability($availability);
        });

        if ($this->availabilityService->validateAvailabilities($availabilities, $request->getDuration())) {
            $eventType = $this->eventTypeRepository->save($eventType);
            $this->eventTypeRepository->saveAvailabilities($eventType, $availabilities->toArray());
        }

        if ($request->getTags()) {
            foreach ($request->getTags() as $newTag) {
                $tag = new Tag();

                $tag->event_type_id = $eventType->id;
                $tag->name = $newTag;

                $this->tagRepository->save($tag);
            }
        }

        return new AddEventTypeResponse($eventType);
    }
}
