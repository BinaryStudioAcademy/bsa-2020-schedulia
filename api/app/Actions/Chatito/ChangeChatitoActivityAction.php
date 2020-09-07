<?php

declare(strict_types=1);

namespace App\Actions\Chatito;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

final class ChangeChatitoActivityAction
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(ChangeChatitoActivityRequest $request)
    {
        $user = $this->userRepository->getById(Auth::id());
        $user->chatito_active = $request->getChatitoActivity();
        $this->userRepository->save($user);
    }
}
