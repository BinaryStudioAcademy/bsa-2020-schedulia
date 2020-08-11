<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Entity\User;

final class ProfilePresenter
{
    public function present(User $profile): array
    {
        return [
            'avatar' => $profile->avatar,
            'branding_logo' => $profile->branding_logo,
            'name' => $profile->name,
            'welcome_message' => $profile->welcome_message,
            'language' => $profile->language,
            'date_format' => $profile->date_format,
            'time_format_12h' => $profile->time_format_12h,
            'country' => $profile->country,
            'timezone' => $profile->timezone
        ];
    }
}
