<?php

namespace Tests\unit;

use App\DataSources\Json;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\JsonKeyUnknownException;
use App\Interfaces\DataSourceInterface;
use PHPUnit\Framework\TestCase;

class DataSourceJsonTest extends TestCase
{
    const TEST_FILE_PATH = 'Storage/test.json';

    private array $sampleData;
    private Json $jsonObject;

    public function setUp(): void
    {
        parent::setUp();

        $this->jsonObject = new Json();

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

        file_put_contents(self::TEST_FILE_PATH, json_encode($this->sampleData));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unlink(self::TEST_FILE_PATH);
    }

    /**
     * Test if can create a new instance from DataSource/Json class
     *
     * @return void
     */
    public function testCreateNewInstanceOfJsonDataSource()
    {
        $json = new Json();
        $this->assertIsObject($json);
        $this->assertInstanceOf(DataSourceInterface::class, $json);
    }

    /**
     * Test if can fetch data from json file
     *
     * @return void
     */
    public function testFetchJsonFileContent()
    {
        $fetchedData = $this->jsonObject->path(self::TEST_FILE_PATH)->entity('countries')->fetch();

        $this->assertIsArray($fetchedData);
        $this->assertCount(count($this->sampleData['countries']), $fetchedData);
        $this->assertEquals($this->sampleData['countries'], $fetchedData);
    }

    /**
     * Test if it throws an exception when json file does not exist in given path
     *
     * @return void
     */
    public function testFetchWrongFilePath()
    {
        $this->expectException(FileNotFoundException::class);

        $this->jsonObject->path('Wrong/file.json')->entity('countries')->fetch();
    }

    /**
     * Test if it throws an exception when json key (entity) is not specified
     *
     * @return void
     */
    public function testFetchWhenEntityIsNotSpecified()
    {
        $this->expectException(JsonKeyUnknownException::class);

        $this->jsonObject->path(self::TEST_FILE_PATH)->fetch();
    }
}
