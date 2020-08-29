<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\CustomField;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

final class CustomFieldRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'custom_fields' => 'array',
            'custom_fields.*.type' => [
                'required',
                'string',
                Rule::in(CustomFieldTypes::getAllTypes())
            ],
            'custom_fields.*.name' => 'required|string'
        ];
    }
}
