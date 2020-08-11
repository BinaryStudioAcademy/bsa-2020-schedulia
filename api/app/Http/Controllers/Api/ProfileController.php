<?php

namespace App\Http\Controllers\Api;

use App\Actions\Profile\UpdateProfileAction;
use App\Actions\Profile\UpdateProfileRequest;
use App\Http\Presenters\ProfilePresenter;
use App\Http\Requests\Api\Profile\UpdateProfileRequest as ProfileRequest;

use Illuminate\Http\JsonResponse;

class ProfileController extends ApiController
{
    private $updateProfileAction;
    private $profilePresenter;

    public function __construct(
        UpdateProfileAction $updateProfileAction,
        ProfilePresenter $profilePresenter

    ) {
        $this->updateProfileAction = $updateProfileAction;
        $this->profilePresenter = $profilePresenter;
    }

    public function store(ProfileRequest $request): JsonResponse
    {
        $response = $this->updateProfileAction->execute(new UpdateProfileRequest(
            $request->get('avatar'),
            $request->get('name'),
            $request->get('welcome_message'),
            $request->get('language'),
            $request->get('date_format'),
            $request->get('time_format_12h'),
            $request->get('country'),
            $request->get('timezone')
        ));

        return $this->successResponse($this->profilePresenter->present($response->getProfile()));
    }

    public function delete($id)
    {
        //
    }
}
