<?php

namespace App\Http\Requests\Api\Event;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'invitee_name' => 'required|string|between:2,50',
            'invitee_email' => 'required|email|max:50',
            'start_date' => 'required',
            'timezone' => 'required|timezone'
        ];
    }
}
