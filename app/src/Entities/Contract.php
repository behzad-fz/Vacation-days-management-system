<?php

namespace App\Entities;

use App\Interfaces\ContractInterface;

class Contract extends AbstractContract implements ContractInterface
{
    protected int $maxVacationDays = 26;

    public function updateMaxVacationDays(int|null $days)
    {
        $this->maxVacationDays = $days ?? $this->maxVacationDays;
    }
}