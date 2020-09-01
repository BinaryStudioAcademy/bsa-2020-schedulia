<?php

namespace App\Services\Calendar;

interface DeleteEventInterface
{
    public function getEventId(): int;
    public function getUserId(): int;
    public function getProviderEventId(): string;
}
