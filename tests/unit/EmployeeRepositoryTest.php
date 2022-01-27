<?php

namespace Tests\unit;

use App\Interfaces\RepositoryInterface;
use App\Repositories\EmployeeRepository;
use PHPUnit\Framework\TestCase;

class EmployeeRepositoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test if can create a new instance from EmployeeRepository class
     *
     * @return void
     */
    public function testCreateNewInstanceOfEmployeeRepository()
    {
        $repository = new EmployeeRepository();
        $this->assertIsObject($repository);
        $this->assertInstanceOf(RepositoryInterface::class, $repository);
    }

    /**
     * Test if can get all of the employees
     *
     * @return void
     */
    public function testGetAllOfTheEmployees()
    {
        $repository = new EmployeeRepository();

        $employees = $repository->getAll();

        $this->assertIsArray($employees);
        $this->assertIsObject($employees[0]);
    }
}
