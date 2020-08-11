<?php

namespace App\Repositories\Event;

use App\Entity\Event;

interface EventRepositoryInterface
{
    public function save(Event $event): Event;
}
