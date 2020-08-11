<?php

namespace App\Http\Controllers\Api;


use App\Actions\Profile\UpdateProfileAction;
use App\Http\Requests\Api\Profile\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends ApiController
{
    private $updateProfileAction;

    public function __construct(
        UpdateProfileAction $updateProfileAction
    )
    {
        $this->updateProfileAction = $updateProfileAction;
    }

    public function store(UpdateProfileRequest $request) : JsonResponse
    {
        return $this->successResponse();
    }

    public function delete($id)
    {
        //
    }
}
