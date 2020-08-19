<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\ApiFormRequest;

final class UpdateUserRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'avatar' => 'nullable|string',
            'branding_logo' => 'nullable|string',
            'name' => 'min:3|nullable|string',
            'welcome_message' => 'max:250|nullable|string',
            'language' => 'max:2|nullable|string',
            'date_format' => 'nullable|string',
            'time_format_12h' => 'boolean',
            'country' => 'nullable|string',
            'timezone' => 'nullable|string',
            'nickname' => 'nullable|string|unique:users',
        ];
    }
}
