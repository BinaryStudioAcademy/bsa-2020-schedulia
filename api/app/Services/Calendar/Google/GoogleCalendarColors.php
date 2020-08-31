<?php

namespace App\Services\Calendar\Google;

class GoogleCalendarColors
{
    public const GOOGLE_EVENT_COLOR_BLUE = 1;
    public const GOOGLE_EVENT_COLOR_GREEN = 2;
    public const GOOGLE_EVENT_COLOR_PURPLE = 3;
    public const GOOGLE_EVENT_COLOR_RED = 4;
    public const GOOGLE_EVENT_COLOR_YELLOW = 5;
    public const GOOGLE_EVENT_COLOR_ORANGE = 6;
    public const GOOGLE_EVENT_COLOR_TURQUOISE = 7;
    public const GOOGLE_EVENT_COLOR_GRAY = 8;
    public const GOOGLE_EVENT_COLOR_BOLD_BLUE = 9;
    public const GOOGLE_EVENT_COLOR_BOLD_GREEN = 10;
    public const GOOGLE_EVENT_COLOR_BOLD_RED = 11;

    private static $colorsMap = [
        'blue' => self::GOOGLE_EVENT_COLOR_BLUE,
        'green' => self::GOOGLE_EVENT_COLOR_BOLD_GREEN,
        'purple' => self::GOOGLE_EVENT_COLOR_PURPLE,
        'red' => self::GOOGLE_EVENT_COLOR_BOLD_RED,
        'yellow' => self::GOOGLE_EVENT_COLOR_YELLOW,
        'orange' => self::GOOGLE_EVENT_COLOR_ORANGE,
        'turquoise' => self::GOOGLE_EVENT_COLOR_TURQUOISE,
        'gray' => self::GOOGLE_EVENT_COLOR_GRAY,
        'bold_blue' => self::GOOGLE_EVENT_COLOR_BOLD_BLUE,
        'bold_green' => self::GOOGLE_EVENT_COLOR_BOLD_GREEN,
        'bold_red' => self::GOOGLE_EVENT_COLOR_BOLD_RED
    ];

    public static function getColors()
    {
        return self::$colorsMap;
    }
}
