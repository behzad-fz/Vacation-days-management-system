<?php

namespace App\Factories;

use App\Interfaces\OutputFactoryInterface;

class OutputFactory implements OutputFactoryInterface
{
    /**
     * @param $format
     * @param $destination
     * @return mixed
     */
    public function make($format, $destination): mixed
    {
        $outMethod = 'App\OutputFormats\\'.ucfirst($format);

        return new $outMethod($destination ?? null);
    }
}