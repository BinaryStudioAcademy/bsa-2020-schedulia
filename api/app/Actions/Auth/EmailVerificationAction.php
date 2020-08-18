<?php


namespace App\Actions\Auth;


use App\Repositories\User\UserRepository;
use Illuminate\Http\JsonResponse;

final class EmailVerificationAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(EmailVerificationRequest $request): JsonResponse
    {
        $user = $this->userRepository->getById($request->getId());

        if (!hash_equals((string) $request->getHash(), sha1($user->getEmailForVerification()))) {
            return response()->json([
                'message' => 'Unauthorized'
            ]);
        }

        if (!$user->hasVerifiedEmail()) {

            $this->userRepository->markUserEmail($user);

        } else {
            return response()->json([
                'message' => 'User already verified!'
            ]);
        }

        return response()->json([
            'message' => 'Email verified successfully!'
        ]);
    }
}
