<?php

namespace App\Http\Requests\Api\Tag;

use App\Http\Requests\ApiFormRequest;

class TagRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|between:2,50',
            'event_type_id' => 'required|integer|exists:event_types,id',
        ];
    }
}
