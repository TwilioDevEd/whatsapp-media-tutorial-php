<?php


namespace App\Services;


class CurlFileRetrieveService implements FileRetrieveService
{

    public function requestContent(string $url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $data  = curl_exec($curl);
        curl_close($curl);

        return $data;
    }
}