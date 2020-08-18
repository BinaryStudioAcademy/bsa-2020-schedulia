<?php

namespace App\Http\Requests\Api\Uploader;

use App\Http\Requests\ApiFormRequest;

final class UploadImageRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required|string',
            'file' => 'required|image'
        ];
    }
}
