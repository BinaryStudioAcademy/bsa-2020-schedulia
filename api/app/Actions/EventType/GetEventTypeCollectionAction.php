<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Repositories\EventType\Criterion\OwnerCriterion;
use App\Repositories\EventType\Criterion\NameCriterion;
use App\Repositories\EventType\EventTypeRepository;
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
        if ($request->getSearchString()) {
            $response = $this->eventTypeRepository->findByCriteria(
                new OwnerCriterion(Auth::id()),
                new NameCriterion($request->getSearchString())
            );
        } else {
            $response = $this->eventTypeRepository->findByCriteria(
                new OwnerCriterion(Auth::id())
            );
        }

        return new GetEventTypeCollectionResponse($response);
    }
}
