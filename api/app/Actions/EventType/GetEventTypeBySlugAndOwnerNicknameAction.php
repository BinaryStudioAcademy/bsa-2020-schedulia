<?php

declare(strict_types=1);

namespace App\Actions\EventType;

use App\Exceptions\EventTypeNotFoundException;
use App\Exceptions\User\UserNotFoundException;
use App\Repositories\EventType\Criterion\OwnerCriterion;
use App\Repositories\EventType\Criterion\SlugCriterion;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use App\Repositories\User\Criterion\NicknameCriterion;
use App\Repositories\User\UserRepositoryInterface;

final class GetEventTypeBySlugAndOwnerNicknameAction
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

    public function execute(GetEventTypeBySlugAndOwnerNicknameRequest $request)
    {
        $owner = $this->userRepository->findOneByCriteria(
            new NicknameCriterion($request->getOwnerNickname())
        );

        if (is_null($owner)) {
            throw new UserNotFoundException();
        }

        $criteria = [
            new OwnerCriterion($owner->id),
            new SlugCriterion($request->getSlug())
        ];

        $eventType = $this->eventTypeRepository->findOneByCriteria($criteria);

        if (is_null($eventType)) {
            throw new EventTypeNotFoundException();
        }

        return new GetEventTypeBySlugAndOwnerNicknameResponse($eventType);
    }
}
