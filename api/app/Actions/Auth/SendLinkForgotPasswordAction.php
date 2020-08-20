<?php

namespace App\Actions\Auth;

use App\Exceptions\User\UserNotFoundException;
use App\Repositories\User\UserRepository;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Password;

final class SendLinkForgotPasswordAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function execute(SendLinkForgotPasswordRequest $request)
    {
        if (!$this->userRepository->getByEmail($request->getEmail())) {
            throw new UserNotFoundException();
        }
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $linkReset = $this->resetUrl($notifiable, $token);
            $count = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');
            return (new MailMessage())
                ->subject(Lang::get('Reset Password from Schedulia'))
                ->view('emails.sendLinkResetPassword', ['linkReset' =>$linkReset, 'count'=>$count]);
        });
        Password::sendResetLink(['email' =>$request->getEmail()]);
    }
    protected function resetUrl($notifiable, $token)
    {
        return  env('CLIENT_APP_URL') . '/reset-password?' . http_build_query(
            [
                    'token' => $token,
                    'email' => $notifiable->getEmailForPasswordReset(),
                ]
        );
    }
}
