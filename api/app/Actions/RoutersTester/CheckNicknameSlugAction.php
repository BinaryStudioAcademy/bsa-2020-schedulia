<?php

namespace App\Actions\RoutersTester;

use App\Exceptions\NicknameNotExistException;
use App\Exceptions\NicknameSlugNotExistException;
use App\Repositories\EventType\Criterion\OwnerCriterion;
use App\Repositories\EventType\Criterion\SlugCriterion;
use App\Repositories\EventType\EventTypeRepository;
use App\Repositories\User\Criterion\NicknameCriterion;
use App\Repositories\User\UserRepository;

class CheckNicknameSlugAction
{
    private UserRepository $userRepository;
    private EventTypeRepository $eventTypeRepository;

    public function __construct(
        UserRepository $userRepository,
        EventTypeRepository $eventTypeRepository
    ) {
        $this->userRepository = $userRepository;
        $this->eventTypeRepository = $eventTypeRepository;
    }

    public function execute(CheckNicknameSlugRequest $request)
    {
        $criteria = new NicknameCriterion($request->getNickname());
        $owner = $this->userRepository->findOneByCriteria($criteria);
        if (is_null($owner)) {
            throw new NicknameNotExistException();
        };
        $criteria = [
            new OwnerCriterion($owner->id),
            new SlugCriterion($request->getSlug())
        ];
        $eventTypeByOwnerSlug = $this->eventTypeRepository->findOneByCriteria(...$criteria);
        if (is_null($eventTypeByOwnerSlug)) {
            throw new NicknameSlugNotExistException();
        }
    }
}
