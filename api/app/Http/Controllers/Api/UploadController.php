<?php

namespace App\Http\Controllers\Api;

use App\Actions\Upload\UploadImageAction;
use App\Actions\Upload\UploadImageRequest;
use App\Entity\User;
use App\Http\Presenters\ProfileImagePresenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends ApiController
{
    private ProfileImagePresenter $profileImagePresenter;
    private UploadImageAction $uploadImageAction;

    public function __construct(
        ProfileImagePresenter $profileImagePresenter,
        UploadImageAction $uploadImageAction
    ) {
        $this->profileImagePresenter = $profileImagePresenter;
        $this->uploadImageAction = $uploadImageAction;
    }

    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $type = $request->type;

        $response = $this->uploadImageAction->execute(new UploadImageRequest(
            $request->file('file'),
            $user->id,
            $type,
            $user->{$type}
        ));

        return $this->successResponse($this->profileImagePresenter->present($response), JsonResponse::HTTP_CREATED);
    }
}
