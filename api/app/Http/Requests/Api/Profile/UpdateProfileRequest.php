<?php

namespace App\Http\Requests\Api\Profile;

use App\Http\Requests\ApiFormRequest;

final class UpdateProfileRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'avatar' => 'nullable|string',
            'branding_logo' => 'nullable|string',
            'name' => 'required|min:3|string',
            'welcome_message' => 'max:250|nullable|string',
            'language' => 'required|max:2|string',
            'date_format' => 'required|string',
            'time_format_12h' => 'required|boolean',
            'country' => 'string',
            'timezone' => 'required|string',
        ];
    }
}
