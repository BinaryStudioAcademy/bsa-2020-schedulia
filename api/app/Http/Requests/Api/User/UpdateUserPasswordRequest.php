<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\ApiFormRequest;

final class UpdateUserPasswordRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'password' => 'required|string|min:8',
            'oldPassword' => 'required|string|min:8'
        ];
    }
}
