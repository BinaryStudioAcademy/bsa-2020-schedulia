<?php

declare(strict_types=1);

namespace App\Actions\User;

final class UpdateUserRequest
{
    private int $userId;
    private ?string $avatar;
    private ?string $brandingLogo;
    private string $name;
    private ?string $welcomeMessage;
    private string $language;
    private string $dateFormat;
    private bool $timeFormat12h;
    private ?string $country;
    private string $timezone;

    public function __construct(
        int $userId,
        ?string $avatar,
        ?string $brandingLogo,
        string $name,
        ?string $welcomeMessage,
        string $language,
        string $dateFormat,
        bool $timeFormat12h,
        ?string $country,
        string $timezone
    ) {
        $this->userId = $userId;
        $this->avatar = $avatar;
        $this->brandingLogo = $brandingLogo;
        $this->name = $name;
        $this->welcomeMessage = $welcomeMessage;
        $this->language = $language;
        $this->dateFormat = $dateFormat;
        $this->timeFormat12h = $timeFormat12h;
        $this->country = $country;
        $this->timezone = $timezone;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
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
    public function getBrandingLogo()
    {
        return $this->brandingLogo;
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
        return $this->dateFormat;
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
        return $this->timeFormat12h;
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
        return $this->welcomeMessage;
    }
}
