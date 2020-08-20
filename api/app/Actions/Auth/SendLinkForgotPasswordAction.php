<?php

namespace App\Actions\Auth;

use App\Exceptions\User\UserNotFoundException;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Password;

final class SendLinkForgotPasswordAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(SendLinkForgotPasswordRequest $request)
    {
        if (!$this->userRepository->getByEmail($request->getEmail())) {
            throw new UserNotFoundException();
        }
        $user = $this->userRepository->getByEmail($request->getEmail());
        $token = Password::createToken($user);
        $user->sendPasswordResetNotification($token);
    }

}
