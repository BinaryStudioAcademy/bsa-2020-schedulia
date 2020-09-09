<?php

namespace App\Http\Controllers\Api;

use App\Actions\RoutersTester\CheckNicknameAction;
use App\Actions\RoutersTester\CheckNicknameRequest;
use App\Actions\RoutersTester\CheckNicknameSlugAction;
use App\Actions\RoutersTester\CheckNicknameSlugRequest;
use App\Actions\User\UpdateUserPasswordAction;
use App\Actions\User\DeleteUserAction;
use App\Actions\User\DeleteUserRequest;
use App\Actions\User\UpdateUserAction;
use App\Actions\User\UpdateUserPasswordRequest;
use App\Actions\User\UpdateUserRequest;
use App\Http\Presenters\UserArrayPresenter;
use App\Http\Requests\Api\User\UpdateUserPasswordRequest as UserPasswordRequest;
use App\Http\Requests\Api\User\UpdateUserRequest as UserRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiController
{
    private UpdateUserAction $updateUserAction;
    private UpdateUserPasswordAction $updateUserPasswordAction;
    private DeleteUserAction $deleteUserAction;
    private UserArrayPresenter $userArrayPresenter;

    public function __construct(
        UpdateUserAction $updateUserAction,
        UpdateUserPasswordAction $updateUserPasswordAction,
        DeleteUserAction $deleteUserAction,
        UserArrayPresenter $userArrayPresenter
    ) {
        $this->updateUserAction = $updateUserAction;
        $this->updateUserPasswordAction = $updateUserPasswordAction;
        $this->deleteUserAction = $deleteUserAction;
        $this->userArrayPresenter = $userArrayPresenter;
    }

    public function store(UserRequest $request): JsonResponse
    {
        $response = $this->updateUserAction->execute(new UpdateUserRequest(
            Auth::id(),
            $request->get('avatar'),
            $request->get('branding_logo'),
            $request->get('name'),
            $request->get('welcome_message'),
            $request->get('language'),
            $request->get('date_format'),
            $request->get('time_format_12h'),
            $request->get('country'),
            $request->get('timezone'),
            $request->get('nickname')
        ));

        return $this->successResponse($this->userArrayPresenter->present($response->getProfile()));
    }

    public function delete(): JsonResponse
    {
        $this->deleteUserAction->execute(new DeleteUserRequest(Auth::id()));

        return $this->emptyResponse();
    }

    public function updatePassword(UserPasswordRequest $request): JsonResponse
    {
        $this->updateUserPasswordAction->execute(new UpdateUserPasswordRequest(
            Auth::id(),
            $request->get('oldPassword'),
            $request->get('password'),
        ));

        return $this->emptyResponse();
    }

    public function checkNickname(
        string $nickname,
        CheckNicknameAction $action
    ) {
        $action->execute(new CheckNicknameRequest($nickname));
        return $this->emptyResponse();
    }

    public function checkNicknameSlug(
        string $nickname,
        string $slug,
        CheckNicknameSlugAction $action
    ) {
        $action->execute(new CheckNicknameSlugRequest($nickname, $slug));
        return $this->emptyResponse();
    }
}
