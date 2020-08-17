<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Repositories\Criteria\OwnerCriteria;
use App\Repositories\Criteria\SearchByNameStringCriteria;
use App\Repositories\EventType\EventTypeRepository;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use Illuminate\Support\Facades\Auth;

final class GetEventTypeCollectionAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;

    public function __construct(EventTypeRepository $eventTypeRepository)
    {
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute(GetEventTypeCollectionRequest $request)
    {
        $response = $this->eventTypeRepository->findByCriteria(
            new OwnerCriteria(Auth::id()),
            new SearchByNameStringCriteria($request->getSearchString())
        );

        return new GetEventTypeCollectionResponse($response);
    }
}
