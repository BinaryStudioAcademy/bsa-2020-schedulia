<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Entity\User;
use App\Repositories\User\Criterion\NicknameCriterion;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class RegisterAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(RegisterRequest $request): RegisterResponse
    {
        $user = new User();
        $user->email = $request->getEmail();
        $user->password = Hash::make($request->getPassword());
        $user->name = $request->getName();
        $user->timezone = $request->getTimezone();
        $user->nickname = $this->generateNickname($request->getEmail());

        $user = $this->userRepository->save($user);

        $user->sendEmailVerificationNotification();

        return new RegisterResponse($user);
    }

    private function generateNickname(string $email): string
    {
        $nickname = explode('@', $email)[0];
        if ($this->userRepository->findOneByCriteria(new NicknameCriterion($nickname))) {
            $nickname .= mb_strtolower(Str::random(2));
        }
        return $nickname;
    }
}
