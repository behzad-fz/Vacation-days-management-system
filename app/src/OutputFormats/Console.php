<?php

namespace App\OutputFormats;

use App\Interfaces\OutputInterface;
use App\Traits\ContentFormatter;

class Console implements OutputInterface
{
    use ContentFormatter;

    /**
     * @param array $data
     */
    public function print(array $data): void
    {
        echo $this->prepareContent($data);
    }
}