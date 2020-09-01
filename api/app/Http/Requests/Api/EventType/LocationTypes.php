<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\EventType;

final class LocationTypes
{
    private const LOCATION = 'location';
    private const ZOOM = 'zoom';

    public static function getAllLocationTypes(): array
    {
        return [
            self::LOCATION,
            self::ZOOM
        ];
    }
}
