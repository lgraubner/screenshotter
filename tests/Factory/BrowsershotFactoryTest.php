<?php

namespace App\Tests\Factory;

use App\Factory\BrowsershotFactory;
use PHPUnit\Framework\TestCase;
use Spatie\Browsershot\Browsershot;

class BrowsershotFactoryTest extends TestCase
{
    public function testCreatesBrowsershotInstance(): void
    {
        $factory = new BrowsershotFactory();

        $browsershot = $factory->create('https://google.com');

        $this->assertInstanceOf(Browsershot::class, $browsershot);
    }
}
