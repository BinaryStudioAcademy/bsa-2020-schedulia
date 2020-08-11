<?php

namespace App\Http\Presenters;


use App\Actions\Auth\RefreshTokenResponse;

final class RefreshTokenResponseArrayPresenter
{
    public function present(RefreshTokenResponse $response): array
    {
        return [
            'access_token' => $response->getAccessToken(),
            'token_type' => $response->getTokenType(),
            'expires_in' => $response->getExpiresIn()
        ];
    }
}
