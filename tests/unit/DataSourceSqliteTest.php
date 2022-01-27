<?php

namespace Tests\unit;

use App\DataSources\Sqlite;
use App\Interfaces\DataSourceInterface;
use PHPUnit\Framework\TestCase;

class DataSourceSqliteTest extends TestCase
{
    const TEST_FILE_PATH = 'Storage/test.sqlite';

    private array $sampleData;
    private Sqlite $sqliteObject;

    public function setUp(): void
    {
        parent::setUp();

        $this->sqliteObject = new Sqlite();

        $this->sampleData = [
            'countries' => [
                [
                    'name' =>  "Germany",
                    'population'  => 83000000,
                    'capital'   => "Berlin"
                ],
                [
                    'name' =>  "Netherlands",
                    'population'  => 17000000,
                    'capital'   => "Amsterdam"
                ]
            ]
        ];

        file_put_contents(self::TEST_FILE_PATH,null);

        $this->sqliteObject->path(self::TEST_FILE_PATH)->createTable('countries', [
            'name' => 'VARCHAR (255) NOT NULL',
            'population' => 'INT NOT NULL',
            'capital' => 'VARCHAR (255) NOT NULL',
        ]);

        $this->sqliteObject->path(self::TEST_FILE_PATH)->entity('countries')->insert($this->sampleData['countries']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unlink(self::TEST_FILE_PATH);
    }

    /**
     * Test if can create a new instance from DataSource/Sqlite class
     *
     * @return void
     */
    public function testCreateNewInstanceOfSqliteDataSource()
    {
        $sqlite = new Sqlite();
        $this->assertIsObject($sqlite);
        $this->assertInstanceOf(DataSourceInterface::class, $sqlite);
    }

    /**
     * Test if can fetch data from sqlite database file
     *
     * @return void
     */
    public function testFetchSqliteFileContent()
    {
        $fetchedData = $this->sqliteObject->path(self::TEST_FILE_PATH)->entity('countries')->fetch();

        $this->assertIsArray($fetchedData);
        $this->assertCount(count($this->sampleData['countries']), $fetchedData);
        $this->assertEquals($this->sampleData['countries'], $fetchedData);
    }
}
