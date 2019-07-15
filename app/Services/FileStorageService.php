<?php


namespace App\Services;


interface FileStorageService
{

    public function saveFile(string $filePath, string $content);

}