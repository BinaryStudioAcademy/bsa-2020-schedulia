<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Exceptions\EventTypeNotFoundException;
use App\Repositories\EventType\Criterion\IdCriterion;
use App\Repositories\EventType\Criterion\OwnerCriterion;
use App\Repositories\EventType\Criterion\ActiveCriterion;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use App\Repositories\User\Criterion\NicknameCriterion;
use App\Repositories\User\UserRepositoryInterface;

final class GetEventTypeByIdAndOwnerNicknameAction
{
    private EventTypeRepositoryInterface $eventTypeRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        EventTypeRepositoryInterface $eventTypeRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->eventTypeRepository = $eventTypeRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(GetEventTypeByIdAndOwnerNicknameRequest $request)
    {
        $owner = $this->userRepository->findOneByCriteria(
            new NicknameCriterion($request->getNickname())
        );

        $criteria = [
            new OwnerCriterion($owner->id),
            new IdCriterion($request->getEventTypeId()),
        ];

        $eventType = $this->eventTypeRepository->findOneByCriteria(...$criteria);

        if (is_null($eventType)) {
            throw new EventTypeNotFoundException();
        }

        return new GetEventTypeByIdAndOwnerNicknameResponse($eventType);
    }
}
