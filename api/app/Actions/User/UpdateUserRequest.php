<?php

declare(strict_types=1);

namespace App\Actions\User;

final class UpdateUserRequest
{
    private int $userId;
    private ?string $avatar;
    private ?string $brandingLogo;
    private ?string $name;
    private ?string $welcomeMessage;
    private ?string $language;
    private ?string $dateFormat;
    private ?bool $timeFormat12h;
    private ?string $country;
    private ?string $timezone;

    public function __construct(
        int $userId,
        ?string $avatar,
        ?string $brandingLogo,
        ?string $name,
        ?string $welcomeMessage,
        ?string $language,
        ?string $dateFormat,
        ?bool $timeFormat12h,
        ?string $country,
        ?string $timezone
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

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function getBrandingLogo(): ?string
    {
        return $this->brandingLogo;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getDateFormat(): ?string
    {
        return $this->dateFormat;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function isTimeFormat12h(): ?bool
    {
        return $this->timeFormat12h;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function getWelcomeMessage(): ?string
    {
        return $this->welcomeMessage;
    }
}
