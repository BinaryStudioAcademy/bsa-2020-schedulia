<?php

namespace App\Http\Presenters;

use App\Actions\Auth\AuthenticationResponse;
use App\Contracts\PresenterInterface;

final class AuthenticationResponseArrayPresenter implements PresenterInterface
{
    public function present(AuthenticationResponse $response): array
    {
        return [
            'access_token' => $response->getAccessToken(),
            'token_type' => $response->getTokenType(),
            'expires_in' => $response->getExpiresIn()
        ];
    }
}
