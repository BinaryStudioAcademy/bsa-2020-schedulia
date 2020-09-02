<?php

declare(strict_types=1);

namespace App\Actions\Event;

use App\Actions\PaginatedResponse;
use App\Repositories\ElasticSearch\Events\Criterion\OwnerCriterion;
use App\Repositories\ElasticSearch\Events\EventAggregateRepositoryInterface;
use App\Repositories\Event\Criterion\EventEmailsCriterion;
use App\Repositories\Event\Criterion\EventStatusCriterion;
use App\Repositories\ElasticSearch\Events\Criterion\EventTypesCriterion;
use App\Repositories\Event\Criterion\SearchStringCriterion;
use App\Repositories\Event\EventRepository;
use App\Repositories\Event\EventRepositoryInterface;
use App\Repositories\Event\Criterion\StartDateCriterion;
use App\Repositories\Event\Criterion\EndDateCriterion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

final class GetEventCollectionAction
{
    private EventAggregateRepositoryInterface $repository;

    public function __construct(EventAggregateRepositoryInterface $eventRepository)
    {
        $this->repository = $eventRepository;
    }

    public function execute(GetEventCollectionRequest $request)
    {
//        $criteria[] = [new OwnerCriterion(Auth::id())];
//
//        if ($request->getEventTypes()) {
//            $criteria[] = new EventTypesCriterion($request->getEventTypes());
//        }

       return $this->repository->search();

//        $criteria = [new OwnerCriterion(Auth::id())];
//
//        if ($request->getStartDate()) {
//            $startDate = Carbon::parse($request->getStartDate())->format('Y-m-d H:m');
//
//            $criteria[] = new StartDateCriterion($startDate);
//        }
//
//        if ($request->getEndDate()) {
//            $endDate = Carbon::parse($request->getEndDate())->format('Y-m-d H:m');
//
//            $criteria[] = new EndDateCriterion($endDate);
//        }
//
//        if ($request->getEventTypes()) {
//            $criteria[] = new EventTypesCriterion($request->getEventTypes());
//        }
//
//        if ($request->getEventEmails()) {
//            $criteria[] = new EventEmailsCriterion($request->getEventEmails());
//        }
//
//        if ($request->getEventStatus()) {
//            $criteria[] = new EventStatusCriterion($request->getEventStatus());
//        }
//
//        if ($request->getSearchString()) {
//            $criteria[] = new SearchStringCriterion($request->getSearchString());
//        }
//
//        return new PaginatedResponse(
//            $this->repository->paginate(
//                $criteria,
//                $request->getPage() ?: EventRepository::DEFAULT_PAGE,
//                $request->getPerPage() ?: EventRepository::DEFAULT_PER_PAGE,
//                $request->getSort() ?: EventRepository::DEFAULT_SORT,
//                $request->getDirection() ?: EventRepository::DEFAULT_DIRECTION,
//            )
//        );
    }
}
