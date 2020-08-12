<?php

declare(strict_types=1);

namespace App\Actions\Upload;

class UploadData
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}