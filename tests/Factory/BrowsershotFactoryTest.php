<?php

namespace App\Tests\Factory;

use App\Factory\BrowsershotFactory;
use PHPUnit\Framework\TestCase;
use Spatie\Browsershot\Browsershot;

class BrowsershotFactoryTest extends TestCase
{
    public function testSomething(): void
    {
        $factory = new BrowsershotFactory();

        $browsershot = $factory->create();

        $this->assertInstanceOf(Browsershot::class, $browsershot);

        $this->markTestIncomplete('Test options');
    }
}
