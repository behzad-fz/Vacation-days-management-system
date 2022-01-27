<?php

namespace App\Services;

use App\Entities\Employee;
use Carbon\Carbon;

class VacationCalculator
{
    /**
     * @var string
     */
    private string $year;

    /**
     * Vacation Calculator constructor.
     *
     * @param string $year
     */
    public function __construct(string $year)
    {
        $this->year = $year;
    }

    /**
     * @param array $employees
     * @return array
     */
    public function calculateMultipleEmployees(array $employees) :array
    {
        $result = [];

        foreach ($employees as $employee) {
            if (! empty($calculation = $this->calculateOneEmployee($employee))) {
                $result[] = $calculation;
            }
        }

        return $result;
    }

    /**
     * @param Employee $em
     * @return array
     */
    public function calculateOneEmployee(Employee $em): array
    {
        $inputYear = Carbon::createFromDate($this->year)->startOfYear();

        // Ignore the employee if the given year is before they were hired
        if ($em->getContractStartDate()->year > $inputYear->year) {
            return [];
        }

        // Initiate the days of vacation according to employee's contract
        $days = $em->getContract()->getMaxVacationDays();

        // If the contract starts during the given year, vacation days should decrease according
        // to number of full months employee will work until the end of the given year
        if (
            $em->isWithinTheFirstYearOfEmployment($inputYear) &&
            ! $em->isContractStartedAtTheBeginningOfTheYear()
        ) {
            $days = $em->getFullMonthsOfEmployment($inputYear->endOfYear()) * $em->getVacationDaysForEachFullMonth();
        }

        // If employee is over 30, they get one extra vacation day every 5 years of employment
        if ($em->isOver30YearsOld($inputYear)) {
            $days += floor(
            $em->getYearsOfEmployment($inputYear->endOfYear()) /
                $em->getContract()::NUMBER_OF_YEARS_OF_EMPLOYMENT_TO_GET_ONE_EXTRA_VACATION_DAY
            );
        }

        return [
            "name" => $em->name,
            "vacation_days" => $days,
        ];
    }
}