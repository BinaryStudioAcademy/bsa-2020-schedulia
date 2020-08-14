<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Repositories\EventType\EventTypeRepository;
use App\Repositories\EventType\EventTypeRepositoryInterface;

final class ChangeDisabledByIdAction
{
    private EventTypeRepositoryInterface $repository;

    public function __construct(EventTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ChangeDisabledByIdRequest $request): void
    {
        $eventType = $this->repository->getById($request->getId());
        $eventType->disabled = $request->getDisabled();
        $this->repository->save($eventType);
    }
}
