<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\SocialAuthAction;
use App\Entity\SocialAccount;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Presenters\AuthenticationResponseArrayPresenter;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends ApiController
{
    private SocialAuthAction $action;
    private AuthenticationResponseArrayPresenter $authenticationResponseArrayPresenter;

    public function __construct(
        SocialAuthAction $action,
        AuthenticationResponseArrayPresenter $authenticationResponseArrayPresenter
    )
    {
        $this->action = $action;
        $this->authenticationResponseArrayPresenter = $authenticationResponseArrayPresenter;
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $response = $this->action->execute($provider);

        return $this->successResponse($this->authenticationResponseArrayPresenter->present($response));
    }
}
