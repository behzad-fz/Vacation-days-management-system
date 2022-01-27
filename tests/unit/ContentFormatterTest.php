<?php

namespace Tests\unit;

use App\Traits\ContentFormatter;
use PHPUnit\Framework\TestCase;

class ContentFormatterTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testTraitFunctionExistsInAnonymousClass()
    {
        $anonymousClass = new class {
            use ContentFormatter;
        };

        $this->assertTrue(method_exists($anonymousClass, 'prepareContent'));
    }

    public function testPrepareContentUsingTrait()
    {
        $object = $this->getObjectForTrait(ContentFormatter::class);

        $content = $object->prepareContent([
            [
                'name'  => "Jack Barker",
                'vacation_days' => 22
            ]
        ]);

        $this->assertIsString($content);
    }
}
