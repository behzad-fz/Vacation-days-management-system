<?php

namespace Tests\unit;

use App\Entities\Employee;
use App\Entities\Contract;
use App\Repositories\EmployeeRepository;
use App\Services\VacationCalculator;
use PHPUnit\Framework\TestCase;

class VacationCalculatorTest extends TestCase
{
    private Contract $contract;
    private EmployeeRepository $employeeRepository;
    private Employee $sampleEmployee;

    public function setUp(): void
    {
        parent::setUp();

        $this->contract = new Contract();
        $this->employeeRepository = new EmployeeRepository();

        $this->sampleEmployee = new Employee();
        $this->sampleEmployee->name = "John";
        $this->sampleEmployee->date_of_birth = "20.03.1980";
        $this->sampleEmployee->contract_start_date = "01.08.2003";
        $this->sampleEmployee->special_contract = null;
        $this->sampleEmployee->special_contract_vacation_days = null;
        $this->sampleEmployee->setContract(new Contract());

        if ($this->sampleEmployee->hasSpecialContract()) {
            $this->sampleEmployee->getContract()->updateMaxVacationDays($this->sampleEmployee->special_contract_vacation_days);
        }
    }

    /**
     * Test if can create a new instance from VacationCalculator class
     *
     * @return void
     */
    public function testCreateNewInstanceOfEmployee()
    {
        $this->expectException(\ArgumentCountError::class);

        new VacationCalculator();
    }

    /**
     * Test if can create a new instance from VacationCalculator class providing arguments
     *
     * @return void
     */
    public function testCreateNewInstanceOfEmployeeWithArguments()
    {
        $calculator = new VacationCalculator(1992);
        $this->assertIsObject($calculator);
    }

    /**
     * Test if can calculate vacation days of one employee
     *
     * @return void
     */
    public function testCalculateVacationDaysOfOneEmployee()
    {
        $calculator = new VacationCalculator(2020);
        $result = $calculator->calculateOneEmployee($this->sampleEmployee);

        $this->assertIsArray($result);
    }

    /**
     * Test if can calculate vacation days of multiple employees
     *
     * @return void
     */
    public function testCalculateVacationDaysOfMultipleEmployees()
    {
        $data = [
            [
                'name' => "John",
                'date_of_birth' => "01.05.1992",
                'contract_start_date' => "15.03.2010",
                'special_contract' => null,
                "special_contract_vacation_days" => null
            ],
            [
                'name' => "Jack",
                'date_of_birth' => "20.03.1980",
                'contract_start_date' => "01.08.2003",
                'special_contract' => "29 vacation days",
                "special_contract_vacation_days" => 27
            ]
        ];

        $employees = $this->employeeRepository->hydrate($data);

        $calculator = new VacationCalculator(2020);
        $result = $calculator->calculateMultipleEmployees($employees);

        $this->assertIsArray($result);
    }

    /**
     * Test if can calculate vacation days of multiple employees where only one of the employees contract start date is valid
     *
     * @return void
     */
    public function testCalculateVacationDaysOfMultipleEmployeesWhereOnlyOneOfTheEmployeesIsValid()
    {
        $data = [
            [
                'name' => "John",
                'date_of_birth' => "01.05.1992",
                'contract_start_date' => "15.03.2016",
                'special_contract' => null,
                "special_contract_vacation_days" => null
            ],
            [
                'name' => "Jack",
                'date_of_birth' => "20.03.1980",
                'contract_start_date' => "01.08.2003",
                'special_contract' => "29 vacation days",
                "special_contract_vacation_days" => 27
            ]
        ];

        $employees = $this->employeeRepository->hydrate($data);

        $calculator = new VacationCalculator(2015);
        $result = $calculator->calculateMultipleEmployees($employees);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
    }

    /**
     * Test if can calculate vacation days of multiple employees where none of the employees are valid
     *
     * @return void
     */
    public function testCalculateVacationDaysOfMultipleEmployeesWhereNoneOfTheEmployeesAreValid()
    {
        $data = [
            [
                'name' => "John",
                'date_of_birth' => "01.05.1992",
                'contract_start_date' => "15.03.2012",
                'special_contract' => null,
                "special_contract_vacation_days" => null
            ],
            [
                'name' => "Jack",
                'date_of_birth' => "20.03.1980",
                'contract_start_date' => "01.08.2020",
                'special_contract' => "29 vacation days",
                "special_contract_vacation_days" => 29
            ]
        ];

        $employees = $this->employeeRepository->hydrate($data);

        $calculator = new VacationCalculator(2009);
        $result = $calculator->calculateMultipleEmployees($employees);

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    /**
     * Test if can calculate vacation days for contract starting at the beginning of the given year
     *
     * @return void
     */
    public function testCalculateVacationDaysForContractStartingAtTheBeginningOfTheGiven()
    {
        $this->sampleEmployee->name = "John";
        $this->sampleEmployee->date_of_birth = "20.03.1980";
        $this->sampleEmployee->contract_start_date = "01.01.2015";

        $calculator = new VacationCalculator(2015);
        $result = $calculator->calculateOneEmployee($this->sampleEmployee);

        $this->assertEquals($this->contract->getMaxVacationDays(), $result['vacation_days']);
    }

    /**
     * Test if can calculate vacation days for contract starting during given year and first of the month
     *
     * @return void
     */
    public function testCalculateVacationDaysForContractStartingDuringTheGivenYearAndFirstOfTheMonth()
    {
        $this->sampleEmployee->date_of_birth = "20.03.1980";
        $this->sampleEmployee->contract_start_date = "01.08.2003";
        $this->sampleEmployee->special_contract = "27 vacation days";
        $this->sampleEmployee->special_contract_vacation_days = 27;
        $this->sampleEmployee->getContract()->updateMaxVacationDays($this->sampleEmployee->special_contract_vacation_days);

        $calculator = new VacationCalculator(2003);
        $result = $calculator->calculateOneEmployee($this->sampleEmployee);

        // vacation day for a full month => 2.25
        // employees full month of employment => 5
        // 5 * 2.25 = 11.25
        $expected = 11.25;

        $this->assertEquals($expected, $result['vacation_days']);
    }

    /**
     * Test if can calculate vacation days for contract starting during given year
     *
     * @return void
     */
    public function testCalculateVacationDaysForContractStartingDuringTheGivenYearAndMiddleOfTheMonth()
    {
        $this->sampleEmployee->date_of_birth = "20.03.1980";
        $this->sampleEmployee->contract_start_date = "15.06.2018";
        $this->sampleEmployee->special_contract = "27 vacation days";
        $this->sampleEmployee->special_contract_vacation_days = 27;
        $this->sampleEmployee->getContract()->updateMaxVacationDays($this->sampleEmployee->special_contract_vacation_days);

        $calculator = new VacationCalculator(2018);
        $result = $calculator->calculateOneEmployee($this->sampleEmployee);

        // vacation day for a full month => 2.25
        // employees full month of employment => 6
        // 6 * 2.25 = 13.5
        $expected = 13.5;

        $this->assertEquals($expected, $result['vacation_days']);
    }

    /**
     * Test if can calculate vacation days for a full year without any additional
     *
     * @return void
     */
    public function testCalculateVacationDaysForFullYearWithoutAnyAdditional()
    {
        $this->sampleEmployee->name = "John";
        $this->sampleEmployee->date_of_birth = "20.03.1980";
        $this->sampleEmployee->contract_start_date = "01.08.2003";
        $this->sampleEmployee->special_contract = null;
        $this->sampleEmployee->setContract(new Contract());

        $calculator = new VacationCalculator(2004);
        $result = $calculator->calculateOneEmployee($this->sampleEmployee);

        $this->assertEquals($this->contract->getMaxVacationDays(), $result['vacation_days']);
    }

    /**
     * Test if can calculate vacation days for a full year with special contract
     *
     * @return void
     */
    public function testCalculateVacationDaysForFullYearWithSpecialContract()
    {
        $this->sampleEmployee->date_of_birth = "20.03.1980";
        $this->sampleEmployee->contract_start_date = "01.08.2003";
        $this->sampleEmployee->special_contract = null;
        $this->sampleEmployee->special_contract_vacation_days = null;
        $this->sampleEmployee->getContract()->updateMaxVacationDays($this->sampleEmployee->special_contract_vacation_days);

        $calculator = new VacationCalculator(2004);
        $result = $calculator->calculateOneEmployee($this->sampleEmployee);

        $this->assertEquals($this->contract->getMaxVacationDays(), $result['vacation_days']);

        // change the contract type
        $this->sampleEmployee->special_contract = "27 days vacation";
        $this->sampleEmployee->special_contract_vacation_days = 27;
        $this->sampleEmployee->getContract()->updateMaxVacationDays($this->sampleEmployee->special_contract_vacation_days);

        $calculator = new VacationCalculator(2004);
        $result = $calculator->calculateOneEmployee($this->sampleEmployee);

        $this->assertEquals(27, $result['vacation_days']);
    }

    /**
     * Test if can calculate vacation days for a full year  for an employee over 30 years and working in the company
     * less than 5 years
     *
     * @return void
     */
    public function testCalculateVacationDaysForFullYearForAnEmployeeOverThirtyYearsButLessThanFiveYearsEmployment()
    {
        $this->sampleEmployee->date_of_birth = "20.03.1980";
        $this->sampleEmployee->contract_start_date = "01.02.2018";
        $this->sampleEmployee->special_contract = null;
        $this->sampleEmployee->setContract(new Contract());

        $calculator = new VacationCalculator(2020);
        $result = $calculator->calculateOneEmployee($this->sampleEmployee);

        $this->assertEquals($this->contract->getMaxVacationDays(), $result['vacation_days']);
    }

    /**
     * Test if can calculate vacation days for a full year  for an employee over 30 years and working in the company
     * less than 5 years
     *
     * @return void
     */
    public function testCalculateVacationDaysForFullYearForAnEmployeeUnderThirtyYearsButMoreThanFiveYearsEmployment()
    {
        $this->sampleEmployee->date_of_birth = "20.03.1992";
        $this->sampleEmployee->contract_start_date = "01.02.2014";
        $this->sampleEmployee->special_contract = null;
        $this->sampleEmployee->setContract(new Contract());

        $calculator = new VacationCalculator(2020);
        $result = $calculator->calculateOneEmployee($this->sampleEmployee);

        $this->assertEquals($this->contract->getMaxVacationDays(), $result['vacation_days']);
    }

    /**
     * Test if can calculate vacation days for a full year  for an employee over 30 years and working in the company
     * less than 5 years
     *
     * @return void
     */
    public function testCalculateVacationDaysForFullYearForAnEmployeeOverThirtyYearsAndMoreThanFiveYearsEmployment()
    {
        $this->sampleEmployee->date_of_birth = "10.04.1985";
        $this->sampleEmployee->contract_start_date = "01.01.2006";
        $this->sampleEmployee->special_contract = null;
        $this->sampleEmployee->setContract(new Contract());

        $calculator = new VacationCalculator(2020);
        $result = $calculator->calculateOneEmployee($this->sampleEmployee);

        // Minimum vacation days + 3 extra days for every 5 years of employment
        $expected = $this->contract->getMaxVacationDays() + 3;

        $this->assertEquals($expected, $result['vacation_days']);
    }

    /**
     * Test if can calculate vacation days for a full year starting in the middle of the year for an employee over 30 years and working in the company
     * less than 5 years
     *
     * @return void
     */
    public function testCalculateVacationDaysForFullYearStartingInTheMiddleOfTheYearForAnEmployeeOverThirtyYearsAndMoreThanFiveYearsEmployment()
    {
        $this->sampleEmployee->date_of_birth = "10.04.1985";
        $this->sampleEmployee->contract_start_date = "02.01.2006";
        $this->sampleEmployee->special_contract = null;
        $this->sampleEmployee->setContract(new Contract());

        $calculator = new VacationCalculator(2020);
        $result = $calculator->calculateOneEmployee($this->sampleEmployee);

        // Minimum vacation days + 3 extra days for every 5 years of employment
        $expected = $this->contract->getMaxVacationDays() + 2;

        $this->assertEquals($expected, $result['vacation_days']);
    }

    /**
     * Test if can calculate vacation days for a full year starting in the middle of the year for an employee over 30 years and working in the company
     * less than 5 years
     *
     * @return void
     */
    public function testCalculateVacationDaysForAnEmployeeBeforeTheContractStarts()
    {
        $this->sampleEmployee->date_of_birth = "10.04.1985";
        $this->sampleEmployee->contract_start_date = "02.01.2016";
        $this->sampleEmployee->special_contract = null;
        $this->sampleEmployee->setContract(new Contract());

        $calculator = new VacationCalculator(2015);
        $result = $calculator->calculateOneEmployee($this->sampleEmployee);

        $this->assertEmpty($result);
        $this->assertArrayNotHasKey('vacation_days', $result);
        $this->assertArrayNotHasKey('name', $result);
    }
}
