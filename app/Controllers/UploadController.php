<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\StorageLibrary;

class UploadController extends BaseController
{
    public function upload()
    {
        $file = $this->request->getFile('file');
        
        if ($file->isValid() && !$file->hasMoved()) {
            $localPath = $file->getTempName();
            $fileName = $file->getRandomName();

            $storage = new StorageLibrary();
            $url = $storage->upload($localPath, 'uploads/' . $fileName);

            return $this->response->setJSON([
                'status' => 'success',
                'url' => $url
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Upload gagal'
        ]);
    }
}
