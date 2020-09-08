<?php

namespace App\Http\Controllers\Api;

use App\Actions\Upload\DeleteImageAction;
use App\Actions\Upload\DeleteImageRequest;
use App\Actions\Upload\UploadImageAction;
use App\Actions\Upload\UploadImageRequest;
use App\Http\Presenters\ProfileImagePresenter;
use App\Http\Requests\Api\Uploader\UploadImageRequest as ImageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends ApiController
{
    private ProfileImagePresenter $profileImagePresenter;
    private UploadImageAction $uploadImageAction;
    private DeleteImageAction $deleteImageAction;

    public function __construct(
        ProfileImagePresenter $profileImagePresenter,
        UploadImageAction $uploadImageAction,
        DeleteImageAction $deleteImageAction
    ) {
        $this->profileImagePresenter = $profileImagePresenter;
        $this->uploadImageAction = $uploadImageAction;
        $this->deleteImageAction = $deleteImageAction;
    }

    public function store(ImageRequest $request): JsonResponse
    {
        $user = Auth::user();
        $type = $request->get('type');

        $response = $this->uploadImageAction->execute(new UploadImageRequest(
            $request->file('file'),
            $user->id,
            $type,
            $user->{$type}
        ));

        return $this->successResponse($this->profileImagePresenter->present($response), JsonResponse::HTTP_CREATED);
    }

    public function delete($type): JsonResponse
    {
        $user = Auth::user();

        $this->deleteImageAction->execute(new DeleteImageRequest(
            $user->id,
            $type
        ));

        return $this->emptyResponse();
    }
}
