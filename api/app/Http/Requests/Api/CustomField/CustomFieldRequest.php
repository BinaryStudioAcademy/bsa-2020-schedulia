<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\CustomField;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class CustomFieldRequest extends FormRequest
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
