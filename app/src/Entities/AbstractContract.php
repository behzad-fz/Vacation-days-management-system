<?php

namespace App\Entities;

abstract class AbstractContract
{
    const NUMBER_OF_MONTHS_PER_YEAR = 12;
    const NUMBER_OF_YEARS_OF_EMPLOYMENT_TO_GET_ONE_EXTRA_VACATION_DAY = 5;

    /**
     * maximum vacation days of the contract
     * @var int
     */
    protected int $maxVacationDays ;

    /**
     * @return int
     */
    public function getMaxVacationDays(): int
    {
        return $this->maxVacationDays;
    }

    /**
     * @return float|int
     */
    public function getVacationDaysForEachFullMonth(): int|float
    {
        return $this->maxVacationDays / self::NUMBER_OF_MONTHS_PER_YEAR;
    }
}