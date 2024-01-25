<?php

namespace App\Service;

class JsonFileReader implements JsonReaderInterface
{
    public function readJsonData(string $jsonFilePath): array
    {
        $jsonData = file_get_contents($jsonFilePath);
        $data = json_decode($jsonData, true);

        return $data ?: [];
    }
}
