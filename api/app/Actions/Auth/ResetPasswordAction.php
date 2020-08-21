<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Exceptions\Auth\InvalidOrExpiredToken;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

final class ResetPasswordAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(ResetPasswordRequest $request)
    {
        $credentials =[
            'email' => $request->getEmail(),
            'password' => Hash::make($request->getPassword()),
            'token'  =>  $request->getToken()
        ];
        $resetPasswordStatus = Password::reset(
            $credentials,
            function ($user, $password) {
                $user->password = $password;
                $this->userRepository->save($user);
            }
        );
        if ($resetPasswordStatus !== Password::PASSWORD_RESET) {
            throw new InvalidOrExpiredToken();
        }
    }
}
