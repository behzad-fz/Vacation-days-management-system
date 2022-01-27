<?php

namespace App\Exceptions;

use Exception;

class FileNotFoundException extends Exception
{
    public function __construct($message, $code = 0)
    {
        $noPathEnteredMessage = 'No file path was specified !';
        $givenFileNotFoundMessage = 'File does not exist in "'.$message.' !"';

        $message = $message ? $givenFileNotFoundMessage : $noPathEnteredMessage;
        $message .= '       (Error on line '.$this->getLine().' in '.$this->getFile().' )';

        parent::__construct($message, $code);
    }
}