<?php

namespace App\Actions\Auth;

use App\Entity\SocialAccount;
use App\Entity\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

final class SocialAuthAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();
        $user = $this->findOrCreateUser($provider, $socialUser);

        $token = auth()->login($user);

        return $token;
    }

    protected function findOrCreateUser($provider, $socialUser)
    {
        $socialAccount = $this->userRepository->getByAccountId($socialUser->getId());
        $user = $this->userRepository->getByEmail($socialUser->getEmail());

        if ($user) {
            return $user;
        }

        if ($socialAccount) {
            $socialAccount->update([
                'token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken
            ]);

            return $socialAccount->user;
        }

        return $this->createUser($provider, $socialUser);
    }

    protected function createUser($provider, $socialUser)
    {

        $user = new User();
        $user->name = $socialUser->getName();
        $user->email = $socialUser->getEmail();
        $user->email_verified_at = now();
        $user->password = Hash::make(rand(10, 10000));

        $user = $this->userRepository->save($user);

        $user->socialAccounts()->create([
            'user_id' => $user->getId(),
            'account_id' => $socialUser->getId(),
            'token' => $socialUser->token,
            'provider_id' => $this->setProviderId($provider),
            'refresh_token' => $socialUser->refreshToken,
            'expires_in' => $socialUser->expiresIn

        ]);

        return $user;
    }

    protected function setProviderId($provider)
    {
        $providerId = 0;

        switch ($provider) {
            case 'google':
                $providerId = SocialAccount::GOOGLE_SERVICE_ID;
                break;
            case 'facebook':
               $providerId = SocialAccount::FACEBOOK_SERVICE_ID;
                break;
        }

        return $providerId;
    }
}
