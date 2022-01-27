<?php

namespace App\OutputFormats;

abstract class AbstractWriteToFile
{
    const APPLICATION_STORAGE_PATH = "Storage";

    /**
     * @param string $path
     */
    protected function createDirectoryIfNotExist(string $path): void
    {
        $path = explode('/', $path);

        $dir = self::APPLICATION_STORAGE_PATH;

        for ($i =0;$i < count($path) - 1;$i++) {
            $dir .= "/".$path[$i];

            if (! file_exists($dir)) {
                mkdir($dir,0777);
            }
        }
    }

    /**
     * @param $data
     * @param $path
     * @return false|int
     */
    protected function generateFile($data, $path): false|int
    {
        return file_put_contents(self::APPLICATION_STORAGE_PATH."/".$path, $data, true);
    }

    /**
     * @param string $path
     */
    protected function echoFileStoredSuccessfully(string $path): void
    {
        echo "\n";
        echo "\tThe report file has been stored here! => ".self::APPLICATION_STORAGE_PATH."/".$path;
        die("\n\n");
    }

    /**
     * @param string $format
     */
    protected function echoFailedToStoreFile(string $format): void
    {
        echo "\n";
        echo "Oops! Error creating ".$format." file...";
        die("\n\n");
    }
}