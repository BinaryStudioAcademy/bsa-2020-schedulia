<?php

declare(strict_types=1);

namespace App\Actions\Slack;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

final class AddSlackNotificationsAction
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(AddSlackNotificationsRequest $request)
    {
        $user = $this->userRepository->getById(Auth::id());

        $user->slack_webhook = $request->getIncomingWebhook();
        $user->slack_channel = $request->getChannelName();
        $user->slack_active = true;

        $this->userRepository->save($user);
    }
}
