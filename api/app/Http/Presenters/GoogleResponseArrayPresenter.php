<?php

namespace App\Http\Presenters;

use App\Actions\SocialAccount\AuthResponse;
use App\Contracts\PresenterInterface;

final class GoogleResponseArrayPresenter implements PresenterInterface
{
    public function present(AuthResponse $authResponse): array
    {
        return [
            'url' => $authResponse->getUrl(),
            'data' => $authResponse->getAuthData()
        ];
    }
}
