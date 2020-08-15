<?php

namespace App\Http\Requests\Api\EventType;

use App\Http\Requests\ApiFormRequest;

class ChangeDisabledEventTypeRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'disabled' => 'required|boolean'
        ];
    }
}
