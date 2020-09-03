<?php

namespace App\Events;

use App\Entity\Event;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventDeleted implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public array $event;

    public function __construct(array $event)
    {
        $this->event = $event;
    }

    public function broadcastAs(): string
    {
        return 'event.deleted';
    }

    public function broadcastOn()
    {
        return new PrivateChannel('events');
    }

    public function getEvent(): array
    {
        return $this->event;
    }
}
