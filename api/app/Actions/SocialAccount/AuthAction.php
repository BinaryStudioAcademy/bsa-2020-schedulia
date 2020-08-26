<?php

declare(strict_types=1);

namespace App\Actions\SocialAccount;

use App\Services\SocialAccount\Google;

class AuthAction
{
    private Google $google;

    public function __construct(
        Google $google
    ) {
        $this->google = $google;
    }

    public function execute(?string $provider, ?string $code = null): string
    {
        if(!$code)
        {
            return $this->$provider->auth();
        } else {
            $this->$provider->authenticate($code);
            $token = $this->$provider->getAccessToken();
            dd($token);

        }
    }

}
