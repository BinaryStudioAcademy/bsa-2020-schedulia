<?php

declare(strict_types=1);

namespace App\Actions\Upload;

use Illuminate\Http\UploadedFile;

final class UploadImageRequest
{
    private int $userId;
    private UploadedFile $file;
    private string $type;
    private ?string $oldFile;

    public function __construct(
        UploadedFile $file,
        int $userId,
        string $type,
        ?string $oldFile

    ) {
        $this->userId = $userId;
        $this->file = $file;
        $this->type = $type;
        $this->oldFile = $oldFile;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOldFile(): string
    {
        return $this->oldFile;
    }
}
