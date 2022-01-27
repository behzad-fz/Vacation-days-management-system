<?php

namespace Tests\unit;

use App\Interfaces\OutputInterface;
use App\OutputFormats\AbstractWriteToFile;
use App\OutputFormats\Json;
use PHPUnit\Framework\TestCase;

class OutputJsonTest extends TestCase
{
    const TEST_FILE_PATH = 'Storage/test.json';

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test if can create a new instance from Json class
     *
     * @return void
     */
    public function testCreateNewInstanceOfJson()
    {
        $output = new Json(self::TEST_FILE_PATH);
        $this->assertIsObject($output);
        $this->assertInstanceOf(OutputInterface::class, $output);
        $this->assertInstanceOf(AbstractWriteToFile::class, $output);
    }

    /**
     * Test if can print to json file
     *
     * @return void
     */
    public function testPrintToJsonFile(): void
    {
        $this->expectNotToPerformAssertions();

        $stub = $this->createStub(Json::class);

        $stub->method('print');

        $stub->print([[]]);
    }
}
