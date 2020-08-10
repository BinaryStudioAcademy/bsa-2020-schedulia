<?php
namespace App\Contracts;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\User;

interface FileUploader {
    public function upload(UploadedFile $file, User $uploadedBy, $type);
    public function remove($fileName);
}