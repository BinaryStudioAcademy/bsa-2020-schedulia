<?php

namespace App\Http\Requests\Api\Event;

use App\Http\Requests\ApiFormRequest;

class EventRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'invitee_name' => 'required|string|between:2,50',
            'invitee_email' => 'required|email|max:50',
            'start_date' => 'required',
            'timezone' => 'required|timezone',
            'event_type_id' => 'required|integer|exists:event_types,id',
            'custom_field_values' => 'array',
            'custom_field_values.*.custom_field_id' => 'required',
            'custom_field_values.*.value' => 'required|string'
        ];
    }
}
