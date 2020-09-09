<?php

declare(strict_types=1);

namespace App\Actions\Tag;

use App\Repositories\Tag\Criterion\DateRangeCriterion;
use App\Repositories\Tag\Criterion\EndDateCriterion;
use App\Repositories\Tag\Criterion\StartDateCriterion;
use App\Repositories\Tag\Criterion\TagsNameCriterion;
use App\Repositories\Tag\TagRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

final class GetTagsByEventDateRangeAction
{
    private TagRepositoryInterface $repository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->repository = $tagRepository;
    }

    public function execute(GetTagsByEventDateRangeRequest $request): GetTagsResponse
    {
        $userId = Auth::id();
        $criteria = [];

        if ($request->getSearchString()) {
            $criteria[] = new TagsNameCriterion($request->getSearchString());
        }

        if ($request->getStartDate() and $request->getEndDate()) {
            $startDate = Carbon::parse($request->getStartDate())->format('Y-m-d H:m');
            $endDate = Carbon::parse($request->getEndDate())->format('Y-m-d H:m');

            $criteria[] = new DateRangeCriterion($startDate, $endDate, $userId);
        } elseif ($request->getStartDate()) {
            $startDate = Carbon::parse($request->getStartDate())->format('Y-m-d H:m');

            $criteria[] = new StartDateCriterion($startDate, $userId);
        } elseif ($request->getEndDate()) {
            $endDate = Carbon::parse($request->getEndDate())->format('Y-m-d H:m');

            $criteria[] = new EndDateCriterion($endDate, $userId);
        }

        return new GetTagsResponse(
            $this->repository->findByCriteria(
                $criteria
            )
        );
    }
}
