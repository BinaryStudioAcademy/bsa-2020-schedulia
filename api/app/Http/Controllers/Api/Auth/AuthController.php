<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\RegisterRequest;
use App\Http\Controllers\Api\ApiController;
use App\Http\Presenters\UserArrayPresenter;
use App\Http\Requests\Auth\RegisterHttpRequest;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    private RegisterAction $registerAction;
    private $presenter;

    public function __construct(
        RegisterAction $registerAction,
        UserArrayPresenter $registerResponseArrayPresenter
    ) {
        $this->registerAction = $registerAction;
        $this->presenter = $registerResponseArrayPresenter;
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

        return $this->successResponse($this->presenter->present($response));
    }
}
