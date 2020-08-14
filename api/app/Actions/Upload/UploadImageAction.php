<?php

declare(strict_types=1);

namespace App\Actions\Upload;

use App\Services\ImageUploader;

final class UploadImageAction
{
    private ImageUploader $imageUploader;

    public function __construct(ImageUploader $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    public function execute(UploadImageRequest $request): UploadImageResponse
    {
        $result = $this->imageUploader->upload($request->getFile(), $request->getUserId(), $request->getType());

        return new UploadImageResponse($result['url'], $result['path']);
    }
}
