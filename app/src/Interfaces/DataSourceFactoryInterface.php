<?php

namespace App\Interfaces;

interface DataSourceFactoryInterface
{
    public function make($source);
}