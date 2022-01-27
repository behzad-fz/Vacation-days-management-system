<?php

namespace App\Facades;

use App\Services\Config as ConfigService;

class Config
{
    public static function __callStatic($method, $arguments)
    {
        $service =  ConfigService::getInstance();

        return call_user_func_array([$service, $method], $arguments);
    }
}