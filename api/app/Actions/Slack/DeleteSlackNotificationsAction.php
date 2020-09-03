<?php

declare(strict_types=1);

namespace App\Actions\Slack;

use Illuminate\Support\Facades\Auth;

final class DeleteSlackNotificationsAction
{
    public function execute()
    {
        $user = Auth::user();
        $user->slack_webhook = null;
        $user->slack_channel = null;
        $user->slack_active = null;
    }
}
