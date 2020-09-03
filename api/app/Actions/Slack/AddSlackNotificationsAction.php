<?php

declare(strict_types=1);

namespace App\Actions\Slack;

use Illuminate\Support\Facades\Auth;

final class AddSlackNotificationsAction
{
    public function execute(AddSlackNotificationsRequest $request)
    {
        $user = Auth::user();

        $user->slack_webhook = $request->getIncomingWebhook();
        $user->slack_channel = $request->getChannelName();

        $user->slack_active = true;
    }
}
