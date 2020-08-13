<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface FileUploader
{
    public function upload(UploadedFile $file, int $userId, string $type): array;
    public function remove(string $fileName): void;
}
