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
            'id' => 'required',
            'custom_fields' => [
                '*' => [
                    'name' => 'required|string',
                    'type' => [
                        'required',
                        'string',
                        Rule::in(CustomFieldTypes::getAllTypes())
                    ]
                ]
            ]
        ];
    }
}
