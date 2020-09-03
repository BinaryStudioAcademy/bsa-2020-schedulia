<?php

declare(strict_types=1);

namespace App\Actions\Slack;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

final class ChangeActivitySlackNotificationsAction
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(ChangeActivitySlackNotificationsRequest $request)
    {
        $user = $this->userRepository->getById(Auth::id());

        $user->slack_active = $request->getActivity();

        $this->userRepository->save($user);
    }
}
