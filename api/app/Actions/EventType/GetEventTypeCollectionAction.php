<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Repositories\EventType\Criterion\OwnerCriterion;
use App\Repositories\EventType\Criterion\NameCriterion;
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
        $criteria = [new OwnerCriterion(Auth::id())];

        if ($request->getSearchString()) {
            $criteria[] = new NameCriterion($request->getSearchString());
        }

        $response = $this->eventTypeRepository->findByCriteria(...$criteria);

        return new GetEventTypeCollectionResponse($response);
    }
}
