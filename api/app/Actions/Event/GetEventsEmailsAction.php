<?php

declare(strict_types=1);

namespace App\Actions\Event;

use App\Repositories\Event\EventRepositoryInterface;
use App\Repositories\Event\Criterion\StartDateCriterion;
use App\Repositories\Event\Criterion\EndDateCriterion;
use App\Repositories\Event\Criterion\OwnerCriterion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

final class GetEventsEmailsAction
{
    private EventRepositoryInterface $repository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->repository = $eventRepository;
    }

    public function execute(GetEventsEmailsRequest $request): GetEventsEmailsResponse
    {
        $criteria = [new OwnerCriterion(Auth::id())];

        if ($request->getStartDate()) {
            $startDate = Carbon::parse($request->getStartDate())->format('Y-m-d H:m');

            $criteria[] = new StartDateCriterion($startDate);
        }

        if ($request->getEndDate()) {
            $endDate = Carbon::parse($request->getEndDate())->format('Y-m-d H:m');

            $criteria[] = new EndDateCriterion($endDate);
        }

        return new GetEventsEmailsResponse(
            $this->repository->getEventsEmails($criteria)
        );
    }
}
