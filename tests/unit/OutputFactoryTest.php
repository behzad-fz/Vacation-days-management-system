<?php

namespace Tests\unit;

use App\Factories\OutputFactory;
use App\Interfaces\OutputFactoryInterface;
use App\Interfaces\OutputInterface;
use App\OutputFormats\Console;
use App\OutputFormats\Json;
use App\OutputFormats\Txt;
use PHPUnit\Framework\TestCase;

class OutputFactoryTest extends TestCase
{
    private OutputFactory $factory;
    public function setUp(): void
    {
        parent::setUp();

        $this->factory = new OutputFactory();
    }

    /**
     * Test if can create a new instance from OutputFactory class
     *
     * @return void
     */
    public function testCreateNewInstanceOfOutputFactory()
    {
        $factory = new OutputFactory();
        $this->assertIsObject($factory);
        $this->assertInstanceOf(OutputFactoryInterface::class, $factory);
    }

    /**
     * Test if can make json file output instance
     *
     * @return void
     */
    public function testMakeJsonFileOutput()
    {
        $this->assertInstanceOf(OutputInterface::class, $this->factory->make('json','foo/bar.json'));
        $this->assertInstanceOf(Json::class, $this->factory->make('json', 'foo/bar.json'));
    }

    /**
     * Test if can make console output instance
     *
     * @return void
     */
    public function testMakeConsoleOutput()
    {
        $this->assertInstanceOf(OutputInterface::class, $this->factory->make('console', null));
        $this->assertInstanceOf(Console::class, $this->factory->make('console', null));
    }

    /**
     * Test if can make text file output instance
     *
     * @return void
     */
    public function testMakeTextFileOutput()
    {
        $this->assertInstanceOf(OutputInterface::class, $this->factory->make('txt', 'foo/bar.txt'));
        $this->assertInstanceOf(Txt::class, $this->factory->make('txt', 'foo/bar.txt'));
    }
}
