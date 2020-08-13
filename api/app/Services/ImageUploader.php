<?php

namespace App\Services;

use App\Contracts\FileUploader;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\UploadedFile;

final class ImageUploader implements FileUploader
{
    private FilesystemManager $fileSystemManager;
    private Repository $config;

    public function __construct(
        FilesystemManager $filesystemManager,
        Repository $config
    ) {
        $this->fileSystemManager = $filesystemManager;
        $this->config = $config;
    }

    public function upload(UploadedFile $file, int $userId, string $type): array
    {
        $newFileName = $this->generateFileName($file->getFilename()) . '.' . $file->getClientOriginalExtension();
        $path = $this->config->get('filesystems.paths.' . $type) . '/' . $userId;

        $result = $this->fileSystemManager
            ->disk()
            ->putFileAs($path, $file, $newFileName, 'public');

        $link = $this->fileSystemManager->disk()->url($path . $newFileName);

        return [
            'url' => $link,
            'path' => $result
        ];
    }

    public function remove(string $file): void
    {
        if ($this->fileSystemManager->exists($file)) {
            $this->fileSystemManager->delete($file);
        }
    }

    private function generateFileName(string $fileName): string
    {
        return md5(uniqid() . $fileName);
    }
}
