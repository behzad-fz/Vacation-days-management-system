<?php

namespace App\Interfaces;

use Carbon\Carbon;

interface EmployeeInterface
{
    public function setContract(ContractInterface $contract): void;

    public function getContract(): ContractInterface;

    public function getVacationDaysForEachFullMonth(): float;

    public function getContractStartDate(): Carbon;

    public function getDOB(): Carbon;

    public function getAge(Carbon $desiredYear = null): int;

    public function getYearsOfEmployment(Carbon $desiredYear = null): int;

    public function isWithinTheFirstYearOfEmployment(Carbon $desiredYear = null): bool;

    public function isContractStartedAtTheBeginningOfTheYear(): bool;

    public function isOver30YearsOld(Carbon $desiredYear = null): bool;

    public function getFullMonthsOfEmployment(Carbon $desiredYear = null): int;
}