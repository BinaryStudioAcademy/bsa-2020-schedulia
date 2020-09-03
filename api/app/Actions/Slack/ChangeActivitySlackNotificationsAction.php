<?php

declare(strict_types=1);

namespace App\Actions\Slack;

use Illuminate\Support\Facades\Auth;

final class ChangeActivitySlackNotificationsAction
{
    public function execute()
    {
        $user = Auth::user();

        $user->slack_active = !$user->slack_active;
    }
}
