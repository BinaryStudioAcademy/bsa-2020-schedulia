<?php

namespace App\Actions\Auth;

use App\Exceptions\AccountVerificationException;
use App\Repositories\User\UserRepository;
use Illuminate\Http\JsonResponse;

final class EmailVerificationAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(EmailVerificationRequest $request)
    {
        $user = $this->userRepository->getById($request->getId());

        if (!hash_equals((string) $request->getHash(), sha1($user->getEmailForVerification()))) {
            throw new AccountVerificationException('Unauthorized');
        }

        if (!$user->hasVerifiedEmail()) {
            $this->userRepository->markUserEmail($user);
        } else {
            throw new AccountVerificationException('User already verified!');
        }
    }
}
