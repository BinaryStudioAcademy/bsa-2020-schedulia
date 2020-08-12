<?php

declare(strict_types=1);

namespace App\Actions\Profile;

use App\Exceptions\Profile\ProfileNotFoundException;
use App\Repositories\User\UserRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

final class UpdateProfileAction
{
    private UserRepository $profileRepository;

    public function __construct(UserRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function execute(UpdateProfileRequest $request): UpdateProfileResponse
    {
        $user = Auth::user();

        $profile = $this->profileRepository->getById($user->id);

        if (!$profile) {
            throw new ProfileNotFoundException();
        }

        $profile->avatar = $request->getAvatar();
        $profile->name = $request->getName();
        $profile->welcome_message = $request->getWelcomeMessage();
        $profile->language = $request->getLanguage() ?: 'en';
        $profile->date_format = $request->getDateFormat() ?: 'american';
        $profile->time_format_12h = $request->isTimeFormat12h();
        $profile->country = $request->getCountry();
        $profile->timezone = $request->getTimezone();

        $profile->save();

        return new UpdateProfileResponse($profile);
    }
}
