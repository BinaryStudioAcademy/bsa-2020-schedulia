<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\SocialAuthAction;
use App\Entity\SocialAccount;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Presenters\AuthenticationResponseArrayPresenter;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\JWTAuth;

class SocialAuthController extends ApiController
{
    private SocialAuthAction $action;

    public function __construct(
        SocialAuthAction $action
    )
    {
        $this->action = $action;
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $response = $this->action->execute($provider);

        return redirect(env('CLIENT_APP_URL') . '/auth/social-callback?token=' . $response);
    }
}
