<?php

declare(strict_types=1);

namespace App\Actions\Tag;

use App\Repositories\Tag\Criterion\EventTypesCriterion;
use App\Repositories\Tag\TagRepositoryInterface;

final class GetTagsByEventTypeIdAction
{
    private TagRepositoryInterface $repository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->repository = $tagRepository;
    }

    public function execute(GetTagsByEventTypeIdRequest $request): GetTagsByEventTypeIdResponse
    {
        $criteria = [];

        if ($request->getEventTypes()) {
            $criteria[] = new EventTypesCriterion($request->getEventTypes());
        }

        return new GetTagsByEventTypeIdResponse(
            $this->repository->get(
                $criteria
            )
        );
    }
}
