<?php

declare(strict_types=1);

namespace App\Actions\Upload;

class UploadImageResponse
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getUrl(): string
    {
        return $this->data['url'];
    }

    public function getPath(): string
    {
        return $this->data['path'];
    }
}
