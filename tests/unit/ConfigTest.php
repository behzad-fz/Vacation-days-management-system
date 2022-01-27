<?php

namespace Tests\unit;

use App\Services\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test if can create a new instance from Config class
     *
     * @return void
     */
    public function testCreateNewInstanceOfConfig()
    {
        $config = new Config();
        $this->assertIsObject($config);
        $this->assertInstanceOf(Config::class, $config);
    }

    /**
     * Test if can get all of the employees
     *
     * @return void
     */
    public function testGetGivenKeyFromConfigFile()
    {
        $this->expectNotToPerformAssertions();

        $config = new Config();

        $config->get('someKey');
    }
}
