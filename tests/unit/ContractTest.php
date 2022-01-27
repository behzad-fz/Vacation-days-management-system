<?php

namespace Tests\unit;

use App\Entities\Contract;
use App\Interfaces\ContractInterface;
use PHPUnit\Framework\TestCase;

class ContractTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test if can create a new instance from Contract class
     *
     * @return void
     */
    public function testCreateNewInstanceOfContract()
    {
        $contract = new Contract();
        $this->assertIsObject($contract);
        $this->assertInstanceOf(ContractInterface::class, $contract);
    }

    /**
     * Test if can get default vacation days
     *
     * @return void
     */
    public function testGetDefaultVacationDays()
    {
        $contract = new Contract();

        $this->assertEquals(26, $contract->getMaxVacationDays());
    }

    /**
     * Test if can get vacation days for each full month
     *
     * @return void
     */
    public function testGetVacationDaysForEachFullMonth()
    {
        $contract = new Contract();

        $this->assertEquals(26 / 12, $contract->getVacationDaysForEachFullMonth());
    }

    /**
     * Test if can update vacation days
     *
     * @return void
     */
    public function testUpdateMaxVacationDays()
    {
        $contract = new Contract();

        $contract->updateMaxVacationDays(35);

        $this->assertEquals(35,$contract->getMaxVacationDays());
    }
}
