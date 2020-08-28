<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Actions\PaginatedResponse;
use App\Repositories\Event\Criterion\GetAllCriterion;
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
        $criteria = [new OwnerCriterion(Auth::id())];

        if ($request->getSearchString()) {
            $criteria[] = new NameCriterion($request->getSearchString());
        }

        $paginator = $this->eventTypeRepository->paginateByCriteria(
            $criteria,
            $request->getPage() ?: EventTypeRepository::DEFAULT_PAGE,
            $request->getPerPage() ?: EventTypeRepository::DEFAULT_PER_PAGE,
            $request->getSorting() ?: EventTypeRepository::DEFAULT_SORTING,
            $request->getDirection() ?: EventTypeRepository::DEFAULT_DIRECTION,
            $request->getAll() ?: EventTypeRepository::DEFAULT_ALL
        );

        return new PaginatedResponse($paginator);
    }
}
