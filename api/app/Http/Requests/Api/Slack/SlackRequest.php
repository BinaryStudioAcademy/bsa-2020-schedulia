<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Slack;

use Illuminate\Foundation\Http\FormRequest;

class SlackRequest extends FormRequest
{
    public function rules()
    {
        return [
            'incoming_webhook' => 'required|string',
            'channel_name' => 'required|string'
        ];
    }
}
