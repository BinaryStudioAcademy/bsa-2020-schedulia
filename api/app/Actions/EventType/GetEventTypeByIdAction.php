<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Actions\GetByIdRequest;
use App\Repositories\EventType\EventTypeRepository;

final class GetEventTypeByIdAction
{
    private $repository;

    public function __construct(EventTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetByIdRequest $request): GetEventTypeByIdResponse
    {
        $eventType = $this->repository->getById($request->getId());

        return new GetEventTypeByIdResponse($eventType);
    }
}
