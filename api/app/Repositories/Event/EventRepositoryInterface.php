<?php

namespace App\Repositories\Event;

use App\Entity\Event;

interface EventRepositoryInterface
{
    public function save(Event $event): Event;
    public function saveCustomFieldValues(Event $event, array $customFieldValues): void;
}
