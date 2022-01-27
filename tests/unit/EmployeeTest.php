<?php

namespace Tests\unit;

use App\Entities\Employee;
use App\Entities\Contract;
use App\Factories\DataSourceFactory;
use App\Interfaces\ContractInterface;
use App\Interfaces\EmployeeInterface;
use App\Repositories\EmployeeRepository;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    private Employee $employeeModel;
    private EmployeeRepository $employeeRepository;
    private DataSourceFactory $dataSourceFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->employeeModel = new Employee();
        $this->employeeRepository = new EmployeeRepository();
        $this->dataSourceFactory = new DataSourceFactory();
    }

    /**
     * Test if can create a new instance from Employee class
     *
     * @return void
     */
    public function testCreateNewInstanceOfEmployee()
    {
        $employee = new Employee();
        $this->assertIsObject($employee);
        $this->assertInstanceOf(EmployeeInterface::class, $employee);
    }

    /**
     * Test if can set a contract for employee and get employee's contract
     *
     * @return void
     */
    public function testSetContractAndGetContractForEmployee()
    {
        $employee = new Employee();
        $employee->setContract(new Contract());

        $this->assertInstanceOf(ContractInterface::class, $employee->getContract());
    }

    /**
     * Test if can get maximum vacation days of an employee according to their contract type
     *
     * @return void
     */
    public function testGetMaximumVacationDaysOfEmployee()
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
                'special_contract' => "27 vacation days",
                "special_contract_vacation_days" => 27
            ]
        ];

        $employees = $this->employeeRepository->hydrate($data);

        $this->assertEquals(26, $employees[0]->getContract()->getMaxVacationDays());
        $this->assertEquals(27, $employees[1]->getContract()->getMaxVacationDays());
    }

    /**
     * Test if can get vacation days of an employee for each full month
     *
     * @return void
     */
    public function testGetVacationDaysOfEmployeeForEachFullMonth()
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
                'special_contract' => "27 vacation days",
                "special_contract_vacation_days" => 27
            ]
        ];

        $employees = $this->employeeRepository->hydrate($data);

        $this->assertEquals( 2.1666666666666665, $employees[0]->getVacationDaysForEachFullMonth());
        $this->assertEquals(2.25, $employees[1]->getVacationDaysForEachFullMonth());
    }

    /**
     * Test if can get contract's start date of an employee
     *
     * @return void
     */
    public function testGetContractStartDateOfEmployee()
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
                'special_contract' => "27 vacation days",
                "special_contract_vacation_days" => 27
            ]
        ];

        $employees = $this->employeeRepository->hydrate($data);

        $this->assertEquals(Carbon::parse($employees[0]->contract_start_date), $employees[0]->getContractStartDate());
        $this->assertEquals(Carbon::parse($employees[1]->contract_start_date), $employees[1]->getContractStartDate());
    }

    /**
     * Test if can get contract's start date of an employee
     *
     * @return void
     */
    public function testGetDateOfBirthOfEmployee()
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
                'special_contract' => "27 vacation days",
                "special_contract_vacation_days" => 27
            ]
        ];

        $employees = $this->employeeRepository->hydrate($data);

        $this->assertEquals(Carbon::parse($employees[0]->date_of_birth), $employees[0]->getDOB());
        $this->assertEquals(Carbon::parse($employees[1]->date_of_birth), $employees[1]->getDOB());
    }

    /**
     * Test if can get age of an employee
     *
     * @return void
     */
    public function testGetAgeOfEmployee()
    {
        $data = [
            [
                'name' => "John",
                'date_of_birth' => "31.12.1992",
                'contract_start_date' => "15.03.2010",
                'special_contract' => null,
                "special_contract_vacation_days" => null
            ],
            [
                'name' => "Jack",
                'date_of_birth' => "20.03.1980",
                'contract_start_date' => "01.08.2003",
                'special_contract' => "27 vacation days",
                "special_contract_vacation_days" => 27
            ]
        ];

        $employees = $this->employeeRepository->hydrate($data);

        $desireDate = Carbon::createFromDate(2020)->endOfYear();

        $this->assertEquals(28 , $employees[0]->getAge($desireDate));
        $this->assertEquals(40, $employees[1]->getAge($desireDate));
    }

    /**
     * Test if can get years of employment of an employee
     *
     * @return void
     */
    public function testGetYearsOfEmploymentOfEmployee()
    {
        $data = [
            [
                'name' => "John",
                'date_of_birth' => "31.12.1992",
                'contract_start_date' => "15.03.2010",
                'special_contract' => null,
                "special_contract_vacation_days" => null
            ],
            [
                'name' => "Jack",
                'date_of_birth' => "20.03.1980",
                'contract_start_date' => "01.01.2019",
                'special_contract' => "27 vacation days",
                "special_contract_vacation_days" => 27
            ]
        ];

        $employees = $this->employeeRepository->hydrate($data);

        $desireDate = Carbon::createFromDate(2020)->endOfYear();

        $this->assertEquals(10 , $employees[0]->getYearsOfEmployment($desireDate));
        $this->assertEquals(2, $employees[1]->getYearsOfEmployment($desireDate));
    }

    /**
     * Test if employee is within the first year of employment
     *
     * @return void
     */
    public function testIfEmployeeIsWithinTheFirstYearOfEmployment()
    {
        $data = [
            [
                'name' => "John",
                'date_of_birth' => "31.12.1992",
                'contract_start_date' => "15.03.2020",
                'special_contract' => null,
                "special_contract_vacation_days" => null
            ],
            [
                'name' => "Jack",
                'date_of_birth' => "20.03.1980",
                'contract_start_date' => "01.01.2019",
                'special_contract' => "27 vacation days",
                "special_contract_vacation_days" => 27
            ]
        ];

        $employees = $this->employeeRepository->hydrate($data);

        $desireDate = Carbon::createFromDate(2020)->endOfYear();

        $this->assertTrue($employees[0]->isWithinTheFirstYearOfEmployment($desireDate));
        $this->assertFalse($employees[1]->isWithinTheFirstYearOfEmployment($desireDate));
    }

    /**
     * Test if employee is hired at the beginning of the year
     *
     * @return void
     */
    public function testIfEmployeeIsHiredAtTheBeginningOfTheYear()
    {
        $data = [
            [
                'name' => "John",
                'date_of_birth' => "15.01.1992",
                'contract_start_date' => "15.03.2020",
                'special_contract' => null,
                "special_contract_vacation_days" => null
            ],
            [
                'name' => "Jack",
                'date_of_birth' => "20.03.1980",
                'contract_start_date' => "01.01.2019",
                'special_contract' => "27 vacation days",
                "special_contract_vacation_days" => 27
            ]
        ];

        $employees = $this->employeeRepository->hydrate($data);

        $desireDate = Carbon::createFromDate(2020)->endOfYear();

        $this->assertFalse($employees[0]->isContractStartedAtTheBeginningOfTheYear($desireDate));
        $this->assertTrue($employees[1]->isContractStartedAtTheBeginningOfTheYear($desireDate));
    }

    /**
     * Test if employee is over thirty years old
     *
     * @return void
     */
    public function testIfIsOverThirtyYearsOld()
    {
        $data = [
            [
                'name' => "John",
                'date_of_birth' => "31.12.1989",
                'contract_start_date' => "15.03.2020",
                'special_contract' => null,
                "special_contract_vacation_days" => null
            ],
            [
                'name' => "Jack",
                'date_of_birth' => "20.03.1995",
                'contract_start_date' => "01.01.2019",
                'special_contract' => "27 vacation days",
                "special_contract_vacation_days" => 27
            ]
        ];

        $employees = $this->employeeRepository->hydrate($data);

        $desireDate = Carbon::createFromDate(2020)->endOfYear();

        $this->assertTrue($employees[0]->isOver30YearsOld($desireDate));
        $this->assertFalse($employees[1]->isOver30YearsOld($desireDate));
    }

    /**
     * Test get number of full months employee has worked
     *
     * @return void
     */
    public function testGetNumberOfFullMonthsEmployeeHasWorked()
    {
        $data = [
            [
                'name' => "John",
                'date_of_birth' => "31.12.1989",
                'contract_start_date' => "01.03.2020",
                'special_contract' => null,
                "special_contract_vacation_days" => null
            ],
            [
                'name' => "Jack",
                'date_of_birth' => "20.03.1995",
                'contract_start_date' => "01.01.2018",
                'special_contract' => "27 vacation days",
                "special_contract_vacation_days" => 27
            ],
            [
                'name' => "Jack",
                'date_of_birth' => "20.03.1995",
                'contract_start_date' => "15.01.2018",
                'special_contract' => "27 vacation days",
                "special_contract_vacation_days" => 27
            ],
            [
                'name' => "Jack",
                'date_of_birth' => "20.03.1995",
                'contract_start_date' => "15.12.2018",
                'special_contract' => "27 vacation days",
                "special_contract_vacation_days" => 27
            ],
            [
                'name' => "Jack",
                'date_of_birth' => "20.03.1995",
                'contract_start_date' => "01.12.2018",
                'special_contract' => "27 vacation days",
                "special_contract_vacation_days" => 27
            ]
        ];

        $employees = $this->employeeRepository->hydrate($data);

        $desireDate = Carbon::createFromDate(2018)->endOfYear();

        $this->assertEquals(0, $employees[0]->getFullMonthsOfEmployment($desireDate));
        $this->assertEquals(12, $employees[1]->getFullMonthsOfEmployment($desireDate));
        $this->assertEquals(11, $employees[2]->getFullMonthsOfEmployment($desireDate));
        $this->assertEquals(0, $employees[3]->getFullMonthsOfEmployment($desireDate));
        $this->assertEquals(1, $employees[4]->getFullMonthsOfEmployment($desireDate));
    }
}
