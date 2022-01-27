<?php

namespace App\Interfaces;

interface OutputFactoryInterface
{
    public function make($format, $destination): mixed;
}