<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\ApiFormRequest;

final class LoginHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8|string'
        ];
    }
}
