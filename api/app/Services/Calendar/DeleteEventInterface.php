<?php

namespace App\Services\Calendar;

interface DeleteEventInterface
{
    public function getUserId(): int;
    public function getProviderId(): string;
}
