<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Exceptions\User\UserNotFoundException;
use App\Repositories\User\UserRepository;

final class UpdateUserAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UpdateUserRequest $request): UpdateUserResponse
    {
        $profile = $this->userRepository->getById($request->getUserId());

        if (!$profile) {
            throw new UserNotFoundException();
        }

        $profile->avatar = $request->getAvatar() ?: $profile->avatar;
        $profile->branding_logo = $request->getBrandingLogo() ?: $profile->branding_logo;
        $profile->name = $request->getName() ?: $profile->name;
        $profile->welcome_message = $request->getWelcomeMessage() ?: $profile->welcome_message;
        $profile->language = $request->getLanguage() ?: $profile->language;
        $profile->date_format = $request->getDateFormat() ?: $profile->date_format;
        $profile->time_format_12h = $request->isTimeFormat12h() ?: $profile->time_format_12h;
        $profile->country = $request->getCountry() ?: $profile->country;
        $profile->timezone = $request->getTimezone() ?: $profile->timezone;
        $profile->nickname = $request->getNickname() ?: $profile->nickname;

        $profile->save();

        return new UpdateUserResponse($profile);
    }
}
