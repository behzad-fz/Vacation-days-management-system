<?php

namespace Tests\unit;

use App\Interfaces\OutputInterface;
use App\OutputFormats\Console;
use PHPUnit\Framework\TestCase;

class OutputConsoleTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test if can create a new instance from Console class
     *
     * @return void
     */
    public function testCreateNewInstanceOfConsole()
    {
        $output = new Console();
        $this->assertIsObject($output);
        $this->assertInstanceOf(OutputInterface::class, $output);
    }

    /**
     * Test if can print to console
     *
     * @return void
     */
    public function testPrintToConsole(): void
    {
        $this->expectNotToPerformAssertions();

        $stub = $this->createStub(Console::class);

        $stub->method('print');

        $stub->print([[]]);
    }
}
