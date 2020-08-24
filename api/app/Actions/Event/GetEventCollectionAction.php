<?php

declare(strict_types=1);

namespace App\Actions\Event;

use App\Repositories\Event\EventRepositoryInterface;
use Illuminate\Support\Facades\Auth;

final class GetEventCollectionAction
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(GetEventCollectionRequest $request): GetEventCollectionResponse
    {
        $events = $this->$eventRepository->findByCriteria();

        return new GetEventCollectionResponse($events);
    }
}
