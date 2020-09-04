<?php

declare(strict_types=1);

namespace App\Actions\Slack;

final class ChangeActivitySlackNotificationsRequest
{
    private bool $activity;

    public function __construct(bool $activity)
    {
        $this->activity = $activity;
    }

    public function getActivity(): bool
    {
        return $this->activity;
    }
}
