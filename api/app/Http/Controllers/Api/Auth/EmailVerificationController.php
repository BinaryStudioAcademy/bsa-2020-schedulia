<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\EmailVerificationAction;
use App\Actions\Auth\EmailVerificationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(Request $request, EmailVerificationAction $action)
    {
        $emailVerificationRequest = new EmailVerificationRequest(
            $request->id,
            $request->hash
        );

        $action->execute($emailVerificationRequest);

        return '';
    }
}
