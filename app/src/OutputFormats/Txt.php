<?php

namespace App\OutputFormats;

use App\Interfaces\OutputInterface;
use App\Traits\ContentFormatter;

class Txt extends AbstractWriteToFile implements OutputInterface
{
    use ContentFormatter;

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

        if ($this->generateFile($this->prepareToWrite($data), $this->filePath)) {
            $this->echoFileStoredSuccessfully($this->filePath);
        }

        $this->echoFailedToStoreFile('text');
    }

    /**
     * @param array $data
     * @return string
     */
    private function prepareToWrite(array $data): string
    {
        return print_r($this->prepareContent($data), true);
    }
}