<?php

namespace Tests\unit;

use App\Exceptions\InvalidFilePathException;
use App\Exceptions\InvalidInputException;
use App\Interfaces\ValidatorInterface;
use App\Validators\InputYearValidator;
use App\Validators\OutputValidator;
use PHPUnit\Framework\TestCase;

class OutputValidatorTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test if can create a new instance from OutputValidator class
     *
     * @return void
     */
    public function testCreateNewInstanceOfOutputValidator()
    {
        $validator = new OutputValidator(1992);
        $this->assertIsObject($validator);
        $this->assertInstanceOf(ValidatorInterface::class, $validator);
    }

    /**
     * Test invalid output format
     *
     * @return void
     */
    public function testInvalidOutputFormat()
    {
        $this->expectException(InvalidInputException::class);

        $validator = new OutputValidator('--format-notSupported');

        $validator->validate();
    }

    /**
     * Test invalid input
     *
     * @return void
     */
    public function testInvalidOutputFilePath()
    {
        $this->expectException(InvalidFilePathException::class);

        $validator = new OutputValidator('--format-json=path/to/fileWithoutExtension');

        $validator->validate();
    }

    /**
     * Test valid output format
     *
     * @return void
     */
    public function testValidOutputFormat()
    {
        $validator = new OutputValidator('--format-json=path/to/file.extension');

        $this->assertEquals(['json', 'path/to/file.json'], $validator->validate());

        $validator = new OutputValidator('--format-txt=path/to/file.extension');

        $this->assertEquals(['txt', 'path/to/file.txt'], $validator->validate());
    }
}
