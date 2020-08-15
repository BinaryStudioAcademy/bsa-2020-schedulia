<?php

namespace App\Actions\Auth;

use App\Exceptions\Auth\UserWithThisEmailDoesNotExist;
use App\Repositories\User\UserRepository;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Password;

final class sendLinkForgotPasswordAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function execute(sendLinkForgotPasswordRequest $request)
    {
        if (!$this->userRepository->getByEmail($request->getEmail())) {
            throw new UserWithThisEmailDoesNotExist($request->getEmail());
        }
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $linkReset = url(config('app.url') . route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], false));
            $count = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');
            return (new MailMessage())
                ->subject(Lang::get('Reset Password from Schedulia'))
                ->view('emails.sendLinkResetPassword', ['linkReset' =>$linkReset, 'count'=>$count]);
        });
        $credentials = ['email' =>$request->getEmail()];
        Password::sendResetLink($credentials);
        return (new sendLinkForgotPasswordResponse(['email' =>$request->getEmail(), 'status'=>200]));
    }
}
