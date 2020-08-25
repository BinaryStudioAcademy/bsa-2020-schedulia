<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Actions\Upload\UploadImageResponse;
use App\Contracts\PresenterInterface;

final class ProfileImagePresenter implements PresenterInterface
{
    public function present(UploadImageResponse $uploadImageResponse): array
    {
        return [
            'url' => $uploadImageResponse->getPath()
        ];
    }
}
