<?php

namespace App\OutputFormats;

use App\Interfaces\OutputInterface;

class Json extends AbstractWriteToFile implements OutputInterface
{
    private  string $filePath;

    public function __construct(string $path)
    {
        $this->filePath = $path;
    }

    /**
     * @param array $data
     */
    public function print(array $data): void
    {
        $this->createDirectoryIfNotExist($this->filePath);

        if ($this->generateFile($this->jsonEncode( $data), $this->filePath)) {
            $this->echoFileStoredSuccessfully($this->filePath);
        }

        $this->echoFailedToStoreFile('json');
    }

    /**
     * @param $data
     * @return false|string
     */
    private function jsonEncode($data): string|false
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}