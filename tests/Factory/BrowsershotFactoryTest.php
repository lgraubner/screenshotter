<?php

namespace App\Tests\Factory;

use App\Factory\BrowsershotFactory;
use PHPUnit\Framework\TestCase;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class BrowsershotFactoryTest extends TestCase
{
    public function testCreatesBrowsershotInstance(): void
    {
        $parameterBag = $this->createMock(ParameterBagInterface::class);

        $parameterBag->expects($this->exactly(3))->method('get')
            ->withConsecutive(
                ['defaults'],
                ['chrome_binary_path'],
                ['no_sandbox'],
            )
            ->willReturnOnConsecutiveCalls([
                'quality' => 70,
                'width' => 1200,
                'height' => 800,
                'fullPage' => false,
                'delay' => 0,
            ], '', false);

        $factory = new BrowsershotFactory($parameterBag);

        $browsershot = $factory->create('https://google.com');

        $this->assertInstanceOf(Browsershot::class, $browsershot);
    }
}
