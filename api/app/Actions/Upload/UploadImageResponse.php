<?php

declare(strict_types=1);

namespace App\Actions\Upload;


class UploadImageResponse
{
    private UploadData $data;

    public function __construct(UploadData $uploadData)
    {
        $this->data = $uploadData;
    }

    public function getUrl(): string
    {
        return $this->data->getUrl();
    }
}