<?php

declare(strict_types=1);

namespace App\Actions\Event;

use App\Actions\PaginatedResponse;
use App\Repositories\Event\Criterion\EventTypesCriterion;
use App\Repositories\Event\EventRepository;
use App\Repositories\Event\EventRepositoryInterface;
use App\Repositories\Event\Criterion\StartDateCriterion;
use App\Repositories\Event\Criterion\EndDateCriterion;
use App\Repositories\Event\Criterion\OwnerCriterion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

final class GetEventCollectionAction
{
    private EventRepositoryInterface $repository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->repository = $eventRepository;
    }

    public function execute(GetEventCollectionRequest $request): PaginatedResponse
    {
        $criteria = [new OwnerCriterion(Auth::id())];

        if ($request->getStartDate()) {
            $startDate = Carbon::parse($request->getStartDate())->format('Y-m-d');

            $criteria[] = new StartDateCriterion($startDate);
        }

        if ($request->getEndDate()) {
            $endDate = Carbon::parse($request->getEndDate())->format('Y-m-d');

            $criteria[] = new EndDateCriterion($endDate);
        }

        if ($request->getEventTypes()) {
            $criteria[] = new EventTypesCriterion($request->getEventTypes());
        }

        return new PaginatedResponse(
            $this->repository->paginate(
                $criteria,
                $request->getPage() ?: EventRepository::DEFAULT_PAGE,
                $request->getPerPage() ?: EventRepository::DEFAULT_PER_PAGE,
                $request->getSort() ?: EventRepository::DEFAULT_SORT,
                $request->getDirection() ?: EventRepository::DEFAULT_DIRECTION,
            )
        );
    }
}
