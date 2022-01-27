<?php

namespace Tests\unit;

use App\Exceptions\InvalidInputException;
use App\Interfaces\ValidatorInterface;
use App\Validators\InputYearValidator;
use PHPUnit\Framework\TestCase;

class InputYearValidatorTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test if can create a new instance from InputYearValidator class
     *
     * @return void
     */
    public function testCreateNewInstanceOfInputYearValidator()
    {
        $validator = new InputYearValidator(1992);
        $this->assertIsObject($validator);
        $this->assertInstanceOf(ValidatorInterface::class, $validator);
    }

    /**
     * Test invalid input
     *
     * @return void
     */
    public function testInvalidInput()
    {
        $this->expectException(InvalidInputException::class);

        $validator = new InputYearValidator('wrong input');

        $validator->validate();
    }

    /**
     * Test valid input
     *
     * @return void
     */
    public function testValidInput()
    {

        $validator = new InputYearValidator(2022);

        $this->assertEquals(2022, $validator->validate());
    }
}
