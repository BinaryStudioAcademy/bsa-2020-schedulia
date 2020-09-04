<?php

namespace App\Http\Requests\Api\Event;

use App\Http\Requests\ApiFormRequest;

class UpdateEventRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'start_date' => 'required|nullable',
            'status' => 'string|nullable'
        ];
    }
}
