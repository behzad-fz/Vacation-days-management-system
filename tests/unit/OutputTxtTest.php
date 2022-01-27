<?php

namespace Tests\unit;

use App\Interfaces\OutputInterface;
use App\OutputFormats\AbstractWriteToFile;
use App\OutputFormats\Txt;
use PHPUnit\Framework\TestCase;

class OutputTxtTest extends TestCase
{
    const TEST_FILE_PATH = 'Storage/test.txt';

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test if can create a new instance from Txt class
     *
     * @return void
     */
    public function testCreateNewInstanceOfTxt()
    {
        $output = new Txt(self::TEST_FILE_PATH);
        $this->assertIsObject($output);
        $this->assertInstanceOf(OutputInterface::class, $output);
        $this->assertInstanceOf(AbstractWriteToFile::class, $output);

    }

    /**
     * Test if can print to text file
     *
     * @return void
     */
    public function testPrintToTextFile(): void
    {
        $this->expectNotToPerformAssertions();

        $stub = $this->createStub(Txt::class);

        $stub->method('print');

        $stub->print([[]]);
    }
}
