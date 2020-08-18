<?php

namespace App\Actions\Auth;

use App\Entity\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

final class LoginAction
{
    public function execute(LoginRequest $request): AuthenticationResponse
    {
        $user = User::where('email', $request->getEmail())->where('email_verified_at', '<>', NULL)->first();

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
