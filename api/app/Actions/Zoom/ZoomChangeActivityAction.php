<?php

namespace App\Actions\Zoom;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

final class ZoomChangeActivityAction
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(ZoomChangeActivityRequest $request)
    {
        $user = $this->userRepository->getById(Auth::id());
        $user->zoom_active = $request->getZoomActivity();
        $this->userRepository->save($user);
    }
}
