<?php

declare(strict_types=1);

namespace App\Actions\Tag;

use App\Entity\Tag;
use App\Repositories\Tag\TagRepositoryInterface;

final class AddTagAction
{
    private TagRepositoryInterface $repository;

    public function __construct(TagRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(AddTagRequest $request): AddTagResponse
    {
        $tag = new Tag();

        $tag->event_type_id = $request->getEventTypeId();
        $tag->name = $request->getName();

        return new AddTagResponse(
            $this->repository->save(
                $tag
            )
        );
    }
}
