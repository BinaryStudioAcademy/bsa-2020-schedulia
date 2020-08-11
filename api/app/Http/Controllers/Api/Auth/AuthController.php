<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\GetAuthenticatedUserAction;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LoginRequest;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\RefreshTokenAction;
use App\Http\Controllers\Api\ApiController;
use App\Http\Presenters\AuthenticationResponseArrayPresenter;
use App\Http\Presenters\RefreshTokenResponseArrayPresenter;
use App\Http\Requests\Api\Auth\LoginHttpRequest;
use Illuminate\Http\JsonResponse;
use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\RegisterRequest;
use App\Http\Presenters\UserArrayPresenter;
use App\Http\Requests\Auth\RegisterHttpRequest;
use Illuminate\Http\Request;

final class AuthController extends ApiController
{
    private RegisterAction $registerAction;
    private RefreshTokenAction $refreshTokenAction;
    private RefreshTokenResponseArrayPresenter $refreshTokenPresenter;
    private $presenter;

    public function __construct(
        RegisterAction $registerAction,
        RefreshTokenAction $refreshTokenAction,
        UserArrayPresenter $registerResponseArrayPresenter,
        RefreshTokenResponseArrayPresenter $refreshTokenPresenter
    ) {
        $this->registerAction = $registerAction;
        $this->refreshTokenAction = $refreshTokenAction;
        $this->presenter = $registerResponseArrayPresenter;
        $this->refreshTokenPresenter = $refreshTokenPresenter;
    }

    public function register(RegisterHttpRequest $request)
    {
        $response = $this->registerAction->execute(
            new RegisterRequest(
                $request->get('email'),
                $request->get('password'),
                $request->get('name'),
                $request->get('timezone'),
            )
        )->getUser();

        return $this->successResponse($this->presenter->present($response), JsonResponse::HTTP_CREATED);
    }

    public function login(
        LoginHttpRequest $httpRequest,
        LoginAction $action,
        AuthenticationResponseArrayPresenter $authenticationResponseArrayPresenter
    ): JsonResponse {
        $request = new LoginRequest(
            $httpRequest->email,
            $httpRequest->password
        );

        $response = $action->execute($request);

        return $this->successResponse($authenticationResponseArrayPresenter->present($response));
    }

    public function logout(LogoutAction $action): JsonResponse
    {
        $action->execute();

        return $this->emptyResponse();
    }

    public function me(GetAuthenticatedUserAction $action, UserArrayPresenter $userArrayPresenter): JsonResponse
    {
        $response = $action->execute();

        return $this->successResponse($userArrayPresenter->present($response->getUser()));
    }

    public function refresh()
    {
        $response = $this->refreshTokenAction->execute();

        return $this->successResponse($this->refreshTokenPresenter->present($response));
    }
}
