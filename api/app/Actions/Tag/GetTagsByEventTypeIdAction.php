<?php

declare(strict_types=1);

namespace App\Actions\Tag;

use App\Repositories\Tag\Criterion\EventTypeIdCriterion;
use App\Repositories\Tag\TagRepositoryInterface;

final class GetTagsByEventTypeIdAction
{
    private TagRepositoryInterface $repository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->repository = $tagRepository;
    }

    public function execute(GetTagsByEventTypeIdRequest $request): GetTagsResponse
    {
        $criteria = [];

        if ($request->getEventTypeId()) {
            $criteria[] = new EventTypeIdCriterion($request->getEventTypeId());
        }

        return new GetTagsResponse(
            $this->repository->findByCriteria(
                $criteria
            )
        );
    }
}
