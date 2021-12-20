<?php

namespace App\Photos;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileManageInterfacePhotos
{
    /**
     * @param UploadedFile $file
     * @return string
     */

    public function imagePostUpload(UploadedFile $file): string;

    /**
     * @param string $fileName
     * @return mixed
     */
    public function removeImage(string $fileName);
}