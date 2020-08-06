<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

class GetAuthenticatedUserAction
{
    public function execute(): GetAuthenticatedUserResponse
    {
        return new GetAuthenticatedUserResponse(Auth::user());
    }
}
