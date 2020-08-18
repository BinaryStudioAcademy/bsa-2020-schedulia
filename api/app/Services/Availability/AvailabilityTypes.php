<?php

declare(strict_types=1);

namespace App\Services\Availability;

final class AvailabilityTypes
{
    public const EVERY_MONDAY = 'every_monday';
    public const EVERY_TUESDAY = 'every_tuesday';
    public const EVERY_WEDNESDAY = 'every_wednesday';
    public const EVERY_THURSDAY = 'every_thursday';
    public const EVERY_FRIDAY = 'every_friday';
    public const EVERY_SATURDAY = 'every_saturday';
    public const EVERY_SUNDAY = 'every_sunday';
    public const WEEKDAYS = 'weekdays';
    public const WEEKEND = 'weekend';
    public const EXACT_DATE = 'exact_date';
    public const EVERY_DAY = 'every_day';

    public const EVERY_MONDAY_PRIORITY = 2;
    public const EVERY_TUESDAY_PRIORITY = 2;
    public const EVERY_WEDNESDAY_PRIORITY = 2;
    public const EVERY_THURSDAY_PRIORITY = 2;
    public const EVERY_FRIDAY_PRIORITY = 2;
    public const EVERY_SATURDAY_PRIORITY = 2;
    public const EVERY_SUNDAY_PRIORITY = 2;
    public const WEEKDAYS_PRIORITY = 3;
    public const WEEKEND_PRIORITY = 3;
    public const EXACT_DATE_PRIORITY = 1;
    public const EVERY_DAY_PRIORITY = 4;

    public static function getTypes(): array
    {
        return [
            self::EVERY_MONDAY,
            self::EVERY_TUESDAY,
            self::EVERY_WEDNESDAY,
            self::EVERY_THURSDAY,
            self::EVERY_FRIDAY,
            self::EVERY_SATURDAY,
            self::EVERY_SUNDAY,
            self::WEEKDAYS,
            self::WEEKEND,
            self::EXACT_DATE,
            self::EVERY_DAY,
        ];
    }

    public static function getTypesInDependsOnDate(): array
    {
        return [
            self::EVERY_MONDAY,
            self::EVERY_TUESDAY,
            self::EVERY_WEDNESDAY,
            self::EVERY_THURSDAY,
            self::EVERY_FRIDAY,
            self::EVERY_SATURDAY,
            self::EVERY_SUNDAY,
            self::WEEKDAYS,
            self::WEEKEND,
            self::EVERY_DAY,
        ];
    }

    public static function getTypesDependsOnDate(): array
    {
        return [
            self::EXACT_DATE,
        ];
    }
}
