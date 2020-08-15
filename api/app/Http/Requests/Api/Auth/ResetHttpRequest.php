<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\ApiFormRequest;

final class ResetHttpRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:50',
            'password' => 'required|confirmed|min:8|string',
            'token' => 'required'
        ];
    }
}
