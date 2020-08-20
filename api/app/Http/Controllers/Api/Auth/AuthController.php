<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\GetAuthenticatedUserAction;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LoginRequest;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\ResetPasswordAction;
use App\Actions\Auth\ResetPasswordRequest;
use App\Actions\Auth\SendLinkForgotPasswordAction;
use App\Actions\Auth\SendLinkForgotPasswordRequest;
use App\Http\Controllers\Api\ApiController;
use App\Http\Presenters\AuthenticationResponseArrayPresenter;
use App\Http\Requests\Api\Auth\LoginHttpRequest;
use App\Http\Requests\Api\Auth\ResetHttpRequest;
use App\Http\Requests\Api\Auth\sendLinkForgotPasswordHttpRequest;
use Illuminate\Http\JsonResponse;
use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\RegisterRequest;
use App\Http\Presenters\UserArrayPresenter;
use App\Http\Requests\Auth\RegisterHttpRequest;
use Illuminate\Http\Request;

final class AuthController extends ApiController
{
    private RegisterAction $registerAction;
    private $presenter;
    private ResetPasswordAction $resetPasswordAction;

    public function __construct(
        RegisterAction $registerAction,
        UserArrayPresenter $registerResponseArrayPresenter,
        ResetPasswordAction $resetAction
    ) {
        $this->registerAction = $registerAction;
        $this->presenter = $registerResponseArrayPresenter;
        $this->resetPasswordAction = $resetAction;
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

    public function sendLinkForgotPassword(
        sendLinkForgotPasswordHttpRequest $httpRequest,
        SendLinkForgotPasswordAction $action
    ): JsonResponse {
        $request = new SendLinkForgotPasswordRequest($httpRequest->email);
        $action->execute($request);
        return $this->emptyResponse();
    }

    public function resetPassword(ResetHttpRequest $request)
    {
        $this->resetPasswordAction->execute(
            new ResetPasswordRequest(
                $request->get('email'),
                $request->get('password'),
                $request->get('token'),
            )
        );
        return $this->emptyResponse();
    }
}
