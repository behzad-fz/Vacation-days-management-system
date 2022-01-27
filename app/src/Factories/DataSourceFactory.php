<?php

namespace App\Factories;

use App\Interfaces\DataSourceFactoryInterface;

class DataSourceFactory implements DataSourceFactoryInterface
{
    /**
     * @param $source
     * @return mixed
     */
    public function make($source): mixed
    {
        $inputSource = 'App\DataSources\\'.ucfirst($source);

        return new $inputSource();
    }
}