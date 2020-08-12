<?php

namespace App\Http\Controllers\Api;

use App\Actions\User\UpdateUserAction;
use App\Actions\User\UpdateUserRequest;
use App\Http\Presenters\UserArrayPresenter;
use App\Http\Requests\Api\Profile\UpdateProfileRequest as ProfileRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProfileController extends ApiController
{
    private UpdateUserAction $updateUserAction;
    private UserArrayPresenter $userArrayPresenter;

    public function __construct(
        UpdateUserAction $updateUserAction,
        UserArrayPresenter $userArrayPresenter
    ) {
        $this->updateUserAction = $updateUserAction;
        $this->userArrayPresenter = $userArrayPresenter;
    }

    public function store(ProfileRequest $request): JsonResponse
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
            $request->get('timezone')
        ));

        return $this->successResponse($this->userArrayPresenter->present($response->getProfile()));
    }

    public function delete($id)
    {
        //
    }
}
