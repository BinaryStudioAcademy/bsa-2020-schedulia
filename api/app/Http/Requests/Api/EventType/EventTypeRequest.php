<?php

namespace App\Http\Requests\Api\EventType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventTypeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|string',
            'color' => 'required|min:3|string',
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
                'date_format:Y-m-d H:i:s'
            ],
            "availabilities.*.end_date" => [
                'required',
                'string',
                'date_format:Y-m-d H:i:s'
            ],
            "location_type" => Rule::in(LocationTypes::getAllLocationTypes()),
            "coordinates" => "json"
        ];
    }
}
