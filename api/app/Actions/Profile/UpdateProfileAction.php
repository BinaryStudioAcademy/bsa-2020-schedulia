<?php

declare(strict_types=1);

namespace App\Actions\Profile;

use App\Exceptions\EventTypeNotFoundException;
use App\Repositories\EventType\EventTypeRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

final class UpdateProfileAction
{
    private ProfileRepository $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function execute(UpdateProfileRequest $request): UpdateProfileResponse
    {
        return new UpdateProfileResponse();
    }
}
