<?php

namespace Tests\unit;

use App\DataSources\Json;
use App\DataSources\Sqlite;
use App\Factories\DataSourceFactory;
use App\Interfaces\DataSourceFactoryInterface;
use App\Interfaces\DataSourceInterface;
use PHPUnit\Framework\TestCase;

class DataSourceFactoryTest extends TestCase
{
    private DataSourceFactory $factory;

    public function setUp(): void
    {
        parent::setUp();

        $this->factory = new DataSourceFactory();
    }

    /**
     * Test if can create a new instance from DataSourceFactory class
     *
     * @return void
     */
    public function testCreateNewInstanceOfContract()
    {
        $factory = new DataSourceFactory();
        $this->assertIsObject($factory);
        $this->assertInstanceOf(DataSourceFactoryInterface::class, $factory);
    }

    /**
     * Test if can make json data source instance
     *
     * @return void
     */
    public function testMakeJsonDataSource()
    {
        $this->assertInstanceOf(DataSourceInterface::class, $this->factory->make('json'));
        $this->assertInstanceOf(Json::class, $this->factory->make('json'));
    }

    /**
     * Test if can make sqlite data source instance
     *
     * @return void
     */
    public function testMakeSqliteDataSource()
    {
        $this->assertInstanceOf(DataSourceInterface::class, $this->factory->make('sqlite'));
        $this->assertInstanceOf(Sqlite::class, $this->factory->make('sqlite'));
    }
}
