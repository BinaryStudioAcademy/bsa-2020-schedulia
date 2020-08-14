<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\ApiFormRequest;

final class sendLinkForgotPasswordHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email'
        ];
    }
}
