<?php

declare(strict_types=1);

namespace App\Actions\Upload;

class UploadImageResponse
{
    private string $url;
    private string $path;

    public function __construct(string $url, string $path)
    {
        $this->url = $url;
        $this->path = $path;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
