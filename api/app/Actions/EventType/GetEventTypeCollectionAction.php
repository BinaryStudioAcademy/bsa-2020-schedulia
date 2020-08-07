<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Repositories\EventType\EventTypeRepository;
use Illuminate\Support\Facades\Auth;

final class GetEventTypeCollectionAction
{
    private EventTypeRepository $eventTypeRepository;

    public function __construct(EventTypeRepository $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute()
    {
        $response = $this->eventTypeRepository->getEventTypesByOwnerId(Auth::id());

        return new GetEventTypeCollectionResponse($response);
    }
}
