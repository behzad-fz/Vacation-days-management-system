<?php

namespace App\Exceptions;

use Exception;

class JsonKeyUnknownException extends Exception
{
    public function __construct($message = null, $code = 0)
    {
        $message = 'The desired entity (json key) is not specified!';
        $message .= '       (Error on line '.$this->getLine().' in '.$this->getFile().' )';

        parent::__construct($message, $code);
    }
}