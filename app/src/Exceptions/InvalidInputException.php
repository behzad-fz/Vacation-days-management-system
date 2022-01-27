<?php

namespace App\Exceptions;

use Exception;

class InvalidInputException extends Exception
{
    public function __construct($message, $code = 0)
    {
        $message = 'Invalid Input => '.$message;
        $message .= '       (Error on line '.$this->getLine().' in '.$this->getFile().' )';

        parent::__construct($message, $code);
    }
}