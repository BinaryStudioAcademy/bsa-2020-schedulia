<?php

namespace App\Http\Requests\Api\EventType;

use Illuminate\Foundation\Http\FormRequest;

class EventTypeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|string',
            'color' => 'required|min:4|string',
            'description' => 'nullable|min:4|string',
            'slug' => 'required|min:2|string',
            'duration' => 'required|integer',
            'timezone' => 'required|string',
            'disabled' => 'required|boolean',
            "availabilities" => [
                'required',
                'array',
                'min:1'
            ],
            "availabilities.*.type" => [
                'required',
                'string',
            ],
            "availabilities.*.start_date" => [
                'required',
                'string',
            ],
            "availabilities.*.end_date" => [
                'required',
                'string',
            ],
        ];
    }
}
