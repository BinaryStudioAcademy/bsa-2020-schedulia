<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Repositories\EventType\Criterion\ActiveCriterion;
use App\Repositories\EventType\Criterion\OwnerCriterion;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use App\Repositories\User\Criterion\NicknameCriterion;
use App\Repositories\User\UserRepositoryInterface;

final class GetEventTypeCollectionByNicknameAction
{
    private EventTypeRepositoryInterface $eventRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        EventTypeRepositoryInterface $eventRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(GetEventTypeCollectionByNicknameRequest $request): GetEventTypeCollectionByNicknameResponse
    {
        $user = $this->userRepository->findByCriteria(
            new NicknameCriterion($request->getNickname())
        )->all();
        $criteria = [new OwnerCriterion($user[0]['id']), new ActiveCriterion()];
        $eventTypes = $this->eventRepository->findByCriteria(...$criteria);

        return new GetEventTypeCollectionByNicknameResponse($eventTypes);
    }
}
