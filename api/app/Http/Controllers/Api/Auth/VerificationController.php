<?php

namespace App\Http\Controllers\Api\Auth;

use App\Entity\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        $user = User::findOrFail($request->id);

        if (!hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                'message' => 'Unauthorized'
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'User already verified!'
            ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json([
            'message' => 'Email verified successfully!'
        ]);
    }
}
