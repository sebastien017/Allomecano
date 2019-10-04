<?php

namespace App\Service;

use Symfony\Component\Form\Form;

class FileUploadManager
{
        private $targetFolderPath;

    public function __construct(string $targetFolderPath)
    {
        $this->targetFolderPath = $targetFolderPath;
    }

    public function upload(Form $formFile, $userId): ?string
    {
        $file = $formFile->getData();

    if ($file != null) {
        $avatarNameToStore = $userId . '.' . $file->getClientOriginalExtension();
        $userFile = $file->move($this->targetFolderPath, $avatarNameToStore);

        return $userFile->getPathname();
    } else {
        return null;
    }
    }
}