<?php

namespace App\Actions\RoutersTester;

use App\Repositories\User\Criterion\EmailCriterion;
use App\Repositories\User\UserRepositoryInterface;

final class CheckNicknameByEmailAction
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(CheckNicknameByEmailRequest $request)
    {
        $criteria = new EmailCriterion($request->getEmail());

        $user = $this->userRepository->findOneByCriteria($criteria);

        return new CheckNicknameByEmailResponse($user->nickname);
    }
}
