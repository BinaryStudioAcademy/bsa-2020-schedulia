<?php

namespace App\Actions\Auth;

use Illuminate\Auth\AuthenticationException;

final class RefreshTokenAction
{
    public function execute(): RefreshTokenResponse
    {
        $token = auth()->refresh();

        if (!$token) {
            throw new AuthenticationException();
        }

        return new RefreshTokenResponse(
            $token,
            'bearer',
            auth()->factory()->getTTL() * 60
        );
    }
}
