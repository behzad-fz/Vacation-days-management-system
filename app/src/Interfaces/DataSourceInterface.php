<?php

namespace App\Interfaces;

interface DataSourceInterface
{
    public function path(string $path);

    public function entity(string $entityName);

    public function fetch();
}