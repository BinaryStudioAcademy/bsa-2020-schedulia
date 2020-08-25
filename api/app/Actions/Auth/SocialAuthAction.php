<?php


namespace App\Actions\Auth;


use App\Entity\SocialAccount;
use App\Entity\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;
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
        $user = $this->findOrCreateUser($socialUser);

        $token = Auth::attempt([
            'email' => $user->email,
            'password' => $user->password,
        ]);

        return new AuthenticationResponse(
            $token,
            'bearer',
            auth()->factory()->getTTL() * 1440
        );

    }

    protected function findOrCreateUser($socialUser)
    {
        $socialAccount = $this->userRepository->getByProviderid($socialUser->id);

        if ($socialAccount) {
            $socialAccount->update([
                'token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken
            ]);

            return $socialAccount->user;
        }

        return $this->createUser($socialUser);
    }

    protected function createUser($socialUser)
    {
        $user = new User();
        $user->name = $socialUser->getName();
        $user->email = $socialUser->getEmail();
        $user->email_verified_at = now();
        $user->password = Hash::make(rand(10, 10000));

        $user = $this->userRepository->save($user);

        $user->socialAccounts()->create([
            'provider_id' => $socialUser->getId(),
            'token' => $socialUser->token,
            'refresh_token' => $socialUser->refreshToken
        ]);

        return $user;
    }
}
