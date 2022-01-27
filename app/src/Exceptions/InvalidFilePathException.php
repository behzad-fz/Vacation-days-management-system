<?php

namespace App\Exceptions;

use Exception;

class InvalidFilePathException extends Exception
{
    public function __construct($message = null, $code = 0)
    {
        $message = 'Invalid file path '.$message;
        $message .= '       (Error on line '.$this->getLine().' in '.$this->getFile().' )';

        parent::__construct($message, $code);
    }
}