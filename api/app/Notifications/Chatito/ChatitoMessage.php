<?php

declare(strict_types=1);

namespace App\Notifications\Chatito;

use App\Entity\Event;
use Illuminate\Support\Facades\Http;

class ChatitoMessage
{
    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->eventType = $event->eventType;
        $this->user = $event->eventType->owner;

        $this->sendMessageToChatito();
    }

    public function sendMessageToChatito()
    {
        Http::post(env('CHATITO_ENDPOINT'), [
            'data' => [
                'message' => $this->generateMessage()
            ],
            'users' => [
                $this->user->email,
                $this->event->invitee_email,
            ],
            'workspace' => $this->eventType->chatito_workspace
        ]);
    }
}
