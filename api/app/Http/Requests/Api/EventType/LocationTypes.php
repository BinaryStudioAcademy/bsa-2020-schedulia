<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\EventType;

final class LocationTypes
{
    public const ADDRESS = 'address';
    public const ZOOM = 'zoom';
    public const WHALE = 'whale';

    public static function getAllLocationTypes(): array
    {
        return [
            self::ADDRESS,
            self::ZOOM,
            self::WHALE
        ];
    }
}
