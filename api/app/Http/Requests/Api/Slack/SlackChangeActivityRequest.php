<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Slack;

use Illuminate\Foundation\Http\FormRequest;

class SlackChangeActivityRequest extends FormRequest
{
    public function rules()
    {
        return [
            'slack_active' => 'required|bool'
        ];
    }
}
