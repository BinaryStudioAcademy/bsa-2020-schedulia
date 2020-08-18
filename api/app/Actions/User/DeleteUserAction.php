<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Exceptions\User\UserNotFoundException;
use App\Repositories\User\UserRepository;
use App\Services\ImageUploader;

final class DeleteUserAction
{
    private UserRepository $userRepository;
    private ImageUploader $imageUploader;

    public function __construct(
        UserRepository $userRepository,
        ImageUploader $imageUploader
    ) {
        $this->userRepository = $userRepository;
        $this->imageUploader = $imageUploader;
    }

    public function execute(DeleteUserRequest $request): void
    {
        $user = $this->userRepository->getById($request->getUserId());

        if (!$user) {
            throw new UserNotFoundException();
        }

        if ($user->avatar) {
            $this->imageUploader->remove($user->avatar);
        }

        if ($user->branding_logo) {
            $this->imageUploader->remove($user->branding_logo);
        }

        $user->delete();
    }
}
