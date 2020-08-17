<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Repositories\EventType\EventTypeRepositoryInterface;
use Illuminate\Support\Facades\Auth;

final class GetEventTypeCollectionAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;

    public function __construct(EventTypeRepositoryInterface $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute(GetEventTypeCollectionRequest $request)
    {
        $response = $this->eventTypeRepository->getEventTypesByOwnerIdOrSearchString(
            $request->getSearchString(),
            Auth::id()
        );

        return new GetEventTypeCollectionResponse($response);
    }
}
