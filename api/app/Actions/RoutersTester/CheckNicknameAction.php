<?php


namespace App\Actions\RoutersTester;


use App\Exceptions\NicknameNotExistException;
use App\Repositories\User\Criterion\NicknameCriterion;
use App\Repositories\User\UserRepository;

class CheckNicknameAction
{
    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function execute(CheckNicknameRequest $request) {
        $criteria = new NicknameCriterion($request->getNickname());
        if (!$this->userRepository->findOneByCriteria($criteria)) {
            throw new NicknameNotExistException();
        }
    }

}
