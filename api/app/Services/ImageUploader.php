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

    public function upload(UploadedFile $file, int $userId, string $type): string
    {
        $newFileName = $this->generateFileName($file->getFilename()) . '.' . $file->getClientOriginalExtension();
        $path = $this->config->get('filesystems.paths.' . $type) . '/' . $userId;

        $storagePath = $this->fileSystemManager
            ->disk()
            ->putFileAs($path, $file, $newFileName, 'public');

        return $storagePath;
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
