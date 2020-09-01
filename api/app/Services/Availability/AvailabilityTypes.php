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
    public const EXACT_DATE = 'exact_date';
    public const UNAVAILABLE = 'unavailable';
    public const DATE_RANGE_WEEKDAYS = 'date_range_weekdays';
    public const DATE_RANGE_WEEKDAYS_INDEFINITE = 'date_range_weekdays_indefinite';
    public const DATE_RANGE = 'date_range';
    public const DATE_RANGE_INDEFINITE = 'date_range_indefinite';

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
            self::EXACT_DATE,
            self::DATE_RANGE,
            self::DATE_RANGE_INDEFINITE,
            self::DATE_RANGE_WEEKDAYS,
            self::DATE_RANGE_WEEKDAYS_INDEFINITE,
            self::UNAVAILABLE
        ];
    }

    public static function getTypesForEveryDay(): array
    {
        return [
            self::EVERY_MONDAY,
            self::EVERY_TUESDAY,
            self::EVERY_WEDNESDAY,
            self::EVERY_THURSDAY,
            self::EVERY_FRIDAY,
            self::EVERY_SATURDAY,
            self::EVERY_SUNDAY
        ];
    }

    public static function getDateRangeTypes(): array
    {
        return [
            self::DATE_RANGE_WEEKDAYS,
            self::DATE_RANGE_WEEKDAYS_INDEFINITE,
            self::DATE_RANGE,
            self::DATE_RANGE_INDEFINITE,
        ];
    }

    public static function getIndefiniteTypes(): array
    {
        return [
            self::DATE_RANGE_INDEFINITE,
            self::DATE_RANGE_WEEKDAYS_INDEFINITE
        ];
    }

    public static function getWeekdaysTypes(): array
    {
        return [
            self::DATE_RANGE_WEEKDAYS,
            self::DATE_RANGE_WEEKDAYS_INDEFINITE
        ];
    }

    public static function getAllDaysTypes(): array
    {
        return [
            self::DATE_RANGE,
            self::DATE_RANGE_INDEFINITE,
        ];
    }
}
