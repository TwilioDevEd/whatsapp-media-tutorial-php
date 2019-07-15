<?php


namespace App\Services;


class FileSystemStorageService implements FileStorageService
{

    public function saveFile(string $filename, string $content)
    {
        file_put_contents(storage_path( "app/{$filename}"), $content);
    }
}