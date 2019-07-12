<?php


namespace App\Services;


interface FileRetrieveService
{

    public function requestContent(string $url);

}