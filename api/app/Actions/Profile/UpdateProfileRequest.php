<?php

declare(strict_types=1);

namespace App\Actions\Profile;

final class UpdateProfileRequest
{
    private ?string $avatar;
    private string $name;
    private ?string $welcome_message;
    private string $language;
    private string $date_format;
    private bool $time_format_12h;
    private ?string $country;
    private string $timezone;

    public function __construct(
        ?string $avatar,
        string $name,
        ?string $welcome_message,
        string $language,
        string $date_format,
        bool $time_format_12h,
        ?string $country,
        string $timezone
    ) {
        $this->avatar = $avatar;
        $this->name = $name;
        $this->welcome_message = $welcome_message;
        $this->language = $language;
        $this->date_format = $date_format;
        $this->time_format_12h = $time_format_12h;
        $this->country = $country;
        $this->timezone = $timezone;
    }

    /**
     * @return string|null
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->date_format;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isTimeFormat12h()
    {
        return $this->time_format_12h;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @return string|null
     */
    public function getWelcomeMessage()
    {
        return $this->welcome_message;
    }
}
