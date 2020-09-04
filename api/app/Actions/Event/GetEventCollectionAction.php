<?php

declare(strict_types=1);

namespace App\Actions\Event;

use App\Actions\PaginatedResponse;
use App\Repositories\ElasticSearch\Events\Criterion\EndDateCriterion;
use App\Repositories\ElasticSearch\Events\Criterion\EventEmailsCriterion;
use App\Repositories\ElasticSearch\Events\Criterion\EventStatusCriterion;
use App\Repositories\ElasticSearch\Events\Criterion\SearchStringCriterion;
use App\Repositories\ElasticSearch\Events\Criterion\StartDateCriterion;
use App\Repositories\ElasticSearch\Events\ElasticsearchEventAggregateRepository;
use App\Repositories\ElasticSearch\Events\EventAggregateRepositoryInterface;
use App\Repositories\ElasticSearch\Events\Criterion\OwnerCriterion;
use App\Repositories\ElasticSearch\Events\Criterion\EventTypesCriterion;
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
        $criteria = [OwnerCriterion::getCriteria(Auth::id())];

        if ($request->getEventTypes()) {
            $criteria[] = EventTypesCriterion::getCriteria($request->getEventTypes());
        }

        if ($request->getEventEmails()) {
            $criteria[] = EventEmailsCriterion::getCriteria($request->getEventEmails());
        }

        if ($request->getEventStatus()) {
            $criteria[] = EventStatusCriterion::getCriteria($request->getEventStatus());
        }

        if ($request->getStartDate()) {
            $startDate = Carbon::parse($request->getStartDate())->timestamp;

            $criteria[] = StartDateCriterion::getCriteria($startDate);
        }

        if ($request->getEndDate()) {
            $endDate = Carbon::parse($request->getEndDate())->timestamp;

            $criteria[] = EndDateCriterion::getCriteria($endDate);
        }

        if ($request->getSearchString()) {
            $criteria[] = SearchStringCriterion::getCriteria($request->getSearchString());
        }

        return new PaginatedResponse(
            $this->repository->search(
                $criteria,
                $request->getPage() ?: ElasticsearchEventAggregateRepository::DEFAULT_PAGE,
                $request->getPerPage() ?: ElasticsearchEventAggregateRepository::DEFAULT_PER_PAGE,
                $request->getSort() ?: ElasticsearchEventAggregateRepository::DEFAULT_SORT,
                $request->getDirection() ?: ElasticsearchEventAggregateRepository::DEFAULT_DIRECTION,
            )
        );
    }
}
