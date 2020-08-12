<?php

namespace App\Services;

use App\Contracts\FileUploader;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

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
        $fileContent = file_get_contents($file->getRealPath());

        $options = $this->config->get('imageUploader.' . $type);

        $fileName = $this->config->get('imageUploader.root') .
            '/' . $options['folder'] . '/' .
            $userId . '/' .
            $this->generateFileName($file->getFilename()) . '.' . $file->getClientOriginalExtension();

        $defaultDisk = $this->config->get('imageUploader.disk');

        $this->fileSystemManager
            ->disk(Arr::get($options, 'disk', $defaultDisk))
            ->put($fileName, $fileContent);

        return $fileName;
    }

    public function remove(string $fileName): string
    {
        $this->fileSystemManager->delete($fileName);
        return $fileName;
    }

    private function generateFileName(string $fileName): string
    {
        return md5(uniqid() . $fileName);
    }
}
