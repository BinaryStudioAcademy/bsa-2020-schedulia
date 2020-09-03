<?php

declare(strict_types=1);

namespace App\Actions\Slack;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

final class DeleteSlackNotificationsAction
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute()
    {
        $user = $this->userRepository->getById(Auth::id());
        $user->slack_webhook = null;
        $user->slack_channel = null;
        $user->slack_active = false;
        $this->userRepository->save($user);
    }
}
