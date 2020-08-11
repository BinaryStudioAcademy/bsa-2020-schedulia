<?php

namespace App\Http\Requests\Api\Profile;

use App\Http\Requests\ApiFormRequest;

final class UpdateProfileRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|string',
            'language' => 'required|max:2|string',
            'date_format' => 'required|string',
            'time_format_12h' => 'required|boolean',
            'timezone' => 'required|string',
        ];
    }
}
