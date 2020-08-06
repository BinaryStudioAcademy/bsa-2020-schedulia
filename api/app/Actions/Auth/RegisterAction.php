<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Entity\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

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

        $user = $this->userRepository->save($user);

        return new RegisterResponse($user);
    }
}
