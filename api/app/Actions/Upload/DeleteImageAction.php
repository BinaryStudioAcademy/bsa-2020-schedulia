<?php

declare(strict_types=1);

namespace App\Actions\Upload;

use App\Repositories\User\UserRepositoryInterface;
use App\Services\ImageUploader;

final class DeleteImageAction
{
    private ImageUploader $imageUploader;
    private UserRepositoryInterface $userRepository;

    public function __construct(ImageUploader $imageUploader, UserRepositoryInterface $userRepository)
    {
        $this->imageUploader = $imageUploader;
        $this->userRepository = $userRepository;
    }

    public function execute(DeleteImageRequest $request): void
    {
        $type = $request->getType();
        $user = $this->userRepository->getById($request->getUserId());
        $file = $user->$type;

        $this->imageUploader->remove($file);
        $user->branding_logo = null;
        $this->userRepository->save($user);
    }
}
