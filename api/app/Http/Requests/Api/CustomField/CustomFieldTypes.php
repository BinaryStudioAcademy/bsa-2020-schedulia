<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\CustomField;

final class CustomFieldTypes
{
    public const LINE = 'line';

    public static function getAllTypes(): array
    {
        return [
            self::LINE
        ];
    }
}
