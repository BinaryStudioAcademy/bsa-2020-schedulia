<?php

declare(strict_types=1);

namespace App\Actions\Slack;

final class AddSlackNotificationsRequest
{
    private string $incomingWebhook;
    private string $channelName;

    public function __construct(string $incomingWebhook, string $channelName)
    {
        $this->incomingWebhook = $incomingWebhook;
        $this->channelName = $channelName;
    }

    public function getChannelName(): string
    {
        return $this->channelName;
    }

    public function getIncomingWebhook(): string
    {
        return $this->incomingWebhook;
    }
}
