<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Exceptions\Auth\InvalidTokenOrUser;
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

    public function execute(ResetRequest $request): ResetResponse
    {
        $credentials =[
            'email' => $request->getEmail(),
            'password' => Hash::make($request->getPassword()),
            'token'  =>  $request->getToken()
        ];
        $reset_password_status = Password::reset(
            $credentials,
            function ($user, $password) {
                $user->password = $password;
                $this->userRepository->save($user);
            }
        );
        if ($reset_password_status !== Password::PASSWORD_RESET) {
            throw new InvalidTokenOrUser();
        }
        return new ResetResponse(['status'=>201]);
    }
}
