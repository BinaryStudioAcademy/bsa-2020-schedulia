<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Repositories\EventType\EventTypeRepository;
use Illuminate\Support\Facades\Auth;

final class GetEventTypeCollectionAction
{
    private $repository;

    public function __construct(EventTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
        $response = $this->repository->getEventTypesByOwnerId(Auth::id());

        return new GetEventTypeCollectionResponse($response);
    }
}
