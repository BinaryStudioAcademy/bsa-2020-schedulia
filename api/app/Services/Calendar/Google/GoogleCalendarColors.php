<?php

namespace App\Services\Calendar\Google;


class GoogleCalendarColors
{
    const GOOGLE_EVENT_COLOR_BLUE = 1;
    const GOOGLE_EVENT_COLOR_GREEN = 2;
    const GOOGLE_EVENT_COLOR_PURPLE = 3;
    const GOOGLE_EVENT_COLOR_RED = 4;
    const GOOGLE_EVENT_COLOR_YELLOW = 5;
    const GOOGLE_EVENT_COLOR_ORANGE = 6;
    const GOOGLE_EVENT_COLOR_TURQUOISE = 7;
    const GOOGLE_EVENT_COLOR_GRAY = 8;
    const GOOGLE_EVENT_COLOR_BOLD_BLUE = 9;
    const GOOGLE_EVENT_COLOR_BOLD_GREEN = 10;
    const GOOGLE_EVENT_COLOR_BOLD_RED = 11;

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