<?php

namespace App\Service;

interface JsonReaderInterface
{
    public function readJsonData(string $jsonFilePath): array;
}
