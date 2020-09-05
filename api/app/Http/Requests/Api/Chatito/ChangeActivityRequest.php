<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Chatito;

use App\Http\Requests\ApiFormRequest;

final class ChangeActivityRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'chatito_active' => 'required|bool'
        ];
    }
}
