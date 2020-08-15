<?php

namespace App\Actions\Auth;

use App\Exceptions\Auth\UserWithThisEmailDoesNotExist;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Password;

final class sendLinkForgotPasswordAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function execute(sendLinkForgotPasswordRequest $request)
    {
        if (!$this->userRepository->getByEmail($request->getEmail()))
        {
            throw new UserWithThisEmailDoesNotExist($request->getEmail());
        }
        $credentials = ['email' =>$request->getEmail()];
        Password::sendResetLink($credentials);
        return (new sendLinkForgotPasswordResponse( ['email' =>$request->getEmail(), 'status'=>200]));
    }
}
