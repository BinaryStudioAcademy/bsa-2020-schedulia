<?php

namespace App\Services;

use App\Contracts\FileUploader;
use App\User;
use Illuminate\Config\Repository;
use Illuminate\Filesystem\FilesystemManager;

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

    public function upload(
        UploadedFile $file,
        User $uploadedBy,
        $type
    ) {
        $fileContent = file_get_contents($file->getRealPath());

        $options = $this->config->get('imageUploader.' . $type);
        $fileName = $options['folder'] .'/'.$uploadedBy->id.'/'. $this->generateFileName($file).'.'.$file->getClientOriginalExtension();
        $defaultDisk = $this->config->get('imageUploader.disk');

        $this->fileSystemManager
            ->disk(Arr::get($options, 'disk', $defaultDisk))
            ->put($fileName, $fileContent);

        return $fileName;
    }

    public function remove($fileName)
    {
        $this->fileSystemManager->delete($fileName);
        return $fileName;
    }

    private function generateFileName($file){
        return md5(uniqid().$file);
    }

}