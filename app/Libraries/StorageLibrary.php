<?php

namespace App\Libraries;

use Google\Cloud\Storage\StorageClient;

class StorageLibrary
{
    protected $storage;
    protected $bucketName;

    public function __construct()
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=C:\cloudsql\duk-cloud-cd3821dca7b2.json'); // Ganti path JSON-mu
        $this->bucketName = 'pentadosen-bucket'; // Ganti dengan bucket Cloud Storage kamu

        $this->storage = new StorageClient([
            'projectId' => 'duk-cloud', // Ganti dengan Project ID kamu
        ]);
    }

    public function upload($file, $destination)
    {
        $bucket = $this->storage->bucket($this->bucketName);
        $bucket->upload(
            fopen($file, 'r'),
            ['name' => $destination]
        );

        return 'https://storage.googleapis.com/' . $this->bucketName . '/' . $destination;
    }
}
