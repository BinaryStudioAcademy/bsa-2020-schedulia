<?php

namespace App\Actions\Whale;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

final class WhaleChangeActivityAction
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(WhaleChangeActivityRequest $request)
    {
        $user = $this->userRepository->getById(Auth::id());
        $user->whale_active = $request->getWhaleActivity();
        $this->userRepository->save($user);
    }
}
