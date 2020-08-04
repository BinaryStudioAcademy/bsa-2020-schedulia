<?php

declare(strict_types = 1);

namespace App\Http\Request\Api\Auth;

use App\Http\Request\ApiFormRequest;

final class RegisterHttpRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users|max:50',
            'name' => 'required|string|between:2,100',
            'password' => 'required|confirmed|min:8|string',
            'timezone' => 'required'
        ];
    }
}
