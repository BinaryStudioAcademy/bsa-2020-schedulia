<?php

namespace App\Contracts;

interface AvailabilityServiceInterface
{
    public function validateAvailabilities(array $availabilities);
}
