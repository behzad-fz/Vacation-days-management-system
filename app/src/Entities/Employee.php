<?php

namespace App\Entities;

use App\Interfaces\ContractInterface;
use App\Interfaces\EmployeeInterface;
use Carbon\Carbon;

class Employee implements EmployeeInterface
{
    /**
     * @var ContractInterface
     */
    private ContractInterface $contract;

    public function setContract(ContractInterface $contract): void
    {
        $this->contract = $contract;
    }

    /**
     * @return ContractInterface
     */
    public function getContract(): ContractInterface
    {
        return $this->contract;
    }

    /**
     * @return float
     */
    public function getVacationDaysForEachFullMonth(): float
    {
        return $this->getContract()->getVacationDaysForEachFullMonth();
    }

    /**
     * @return Carbon
     */
    public function getContractStartDate(): Carbon
    {
        return Carbon::parse($this->contract_start_date);
    }

    /**
     * @return Carbon
     */
    public function getDOB(): Carbon
    {
        return Carbon::parse($this->date_of_birth);
    }

    /**
     * @param Carbon|null $desiredYear
     * @return int
     */
    public function getAge(Carbon $desiredYear = null): int
    {
        return floor($desiredYear ? $this->getDOB()->diffInYears($desiredYear) : $this->getDOB()->diffInYears(Carbon::now()));
    }

    /**
     * @param Carbon|null $desiredYear
     * @return int
     */
    public function getYearsOfEmployment(Carbon $desiredYear = null): int
    {
        $years = $desiredYear ? $this->getContractStartDate()->diffInYears($desiredYear) : $this->getContractStartDate()->diffInYears(Carbon::now());

        if ($this->getContractStartDate() == $this->getContractStartDate()->firstOfYear()) {
            $years++;
        }

        return floor($years);
    }

    /**
     * @param Carbon|null $desiredYear
     * @return bool
     */
    public function isWithinTheFirstYearOfEmployment(Carbon $desiredYear = null): bool
    {
        return  $this->getContractStartDate()->isSameYear($desiredYear ?? Carbon::now());
    }

    /**
     * @return bool
     */
    public function isContractStartedAtTheBeginningOfTheYear(): bool
    {
        return $this->getContractStartDate()->format('m.d') == "01.01";
    }

    /**
     * @param Carbon|null $desiredYear
     * @return bool
     */
    public function isOver30YearsOld(Carbon $desiredYear = null): bool
    {
        return $this->getAge($desiredYear->endOfYear()) >= 30;
    }

    /**
     * @param Carbon|null $desiredYear
     * @return int
     */
    public function getFullMonthsOfEmployment(Carbon $desiredYear = null): int
    {
        if ($this->getContractStartDate()->greaterThan($desiredYear ?? Carbon::now())) {
            return 0;
        }

        if (! $this->isWithinTheFirstYearOfEmployment($desiredYear)) {
            return 12;
        }

        $monthsOfEmployment = $this->getContractStartDate()->diffInMonths(($desiredYear ?? Carbon::now())->endOfYear());

        return $this->getContractStartDate()->isSameDay($this->getContractStartDate()->firstOfMonth()) ?
            ceil($monthsOfEmployment) : floor($monthsOfEmployment);
    }

    /**
     * @return bool
     */
    public function hasSpecialContract(): bool
    {
        return $this->special_contract ? true : false;
    }
}