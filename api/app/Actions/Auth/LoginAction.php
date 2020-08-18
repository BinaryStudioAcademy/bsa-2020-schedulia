<?php

namespace App\Actions\Auth;

use App\Entity\User;
use App\Repositories\User\UserRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

final class LoginAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(LoginRequest $request): AuthenticationResponse
    {
        $user = $this->userRepository->getByVerifiedEmail($request->getEmail());

        if (!$user) {
            throw new AuthenticationException('Email is not verified');
        }

        $token = Auth::attempt([
            'email' => $request->getEmail(),
            'password' => $request->getPassword()
        ]);

        if (!$token) {
            throw new AuthenticationException();
        }

        return new AuthenticationResponse(
            $token,
            'bearer',
            auth()->factory()->getTTL() * 60
        );
    }
}
