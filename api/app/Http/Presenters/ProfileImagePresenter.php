<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Actions\Upload\UploadImageResponse;

final class ProfileImagePresenter
{
    public function present(UploadImageResponse $uploadImageResponse): array
    {
        return [
            'url' => $uploadImageResponse->getUrl()
        ];
    }
}