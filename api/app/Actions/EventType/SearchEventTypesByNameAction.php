<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Repositories\EventType\EventTypeRepository;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use Illuminate\Support\Facades\Auth;

final class SearchEventTypesByNameAction
{
    private EventTypeRepositoryInterface $repository;

    public function __construct(EventTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(SearchEventTypesByNameRequest $request): SearchEventTypesByNameResponse
    {
        $searchedEventTypes =
            $request->getSearchString()
                ? $this->repository->getByString($request->getSearchString())
                : $this->repository->getEventTypesByOwnerId(Auth::id());

        return new SearchEventTypesByNameResponse($searchedEventTypes);
    }
}
