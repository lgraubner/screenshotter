<?php

namespace App\Tests\Service;

use App\Factory\BrowsershotFactory;
use App\Model\Screenshot;
use App\Service\ScreenshotService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ScreenshotServiceTest extends TestCase
{
    public function testExecuteScreenshot(): void
    {
        $parameterBag = $this->createMock(ParameterBagInterface::class);

        $parameterBag->method('get')
            ->with('screenshot_dir')
            ->willReturn('public/screenshots');

        $browsershotFactory = $this->createMock(BrowsershotFactory::class);
        $logger = $this->createMock(LoggerInterface::class);

        $logger->expects($this->once())->method('info')
            ->with($this->anything());

        $screenshotService = new ScreenshotService($parameterBag, $browsershotFactory, $logger);

        $url = 'https://google.com';

        $screenshot = $screenshotService->execute($url);

        $this->assertInstanceOf(Screenshot::class, $screenshot);
    }
}
