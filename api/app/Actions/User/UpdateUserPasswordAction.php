<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Exceptions\User\UserInvalidPasswordException;
use App\Exceptions\User\UserNotFoundException;
use App\Repositories\User\UserRepository;

use Illuminate\Support\Facades\Hash;

final class UpdateUserPasswordAction
{
    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function execute(UpdateUserPasswordRequest $request): void
    {
        $user = $this->userRepository->getById($request->getUserId());

        if (!$user) {
            throw new UserNotFoundException();
        }

        if(!Hash::check($request->getOldPassword(), $user->password)) {
            throw new UserInvalidPasswordException();
        }

        $user->password = Hash::make($request->getNewPassword());

        $user->save();
    }
}
