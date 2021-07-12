<?php

namespace App\Tests\Service;

use App\Factory\BrowsershotFactory;
use App\Model\Screenshot;
use App\Service\ScreenshotManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ScreenshotManagerTest extends TestCase
{
    public function testExecuteScreenshot(): void
    {
        $parameterBag = $this->createMock(ParameterBagInterface::class);

        $parameterBag->expects($this->exactly(2))
            ->method('get')
            ->withConsecutive(
                [$this->equalTo('screenshot_dir')],
                [$this->equalTo('cache_duration')],
            )
            ->willReturnOnConsecutiveCalls('public/screenshots', 100);

        $url = 'https://google.com';
        $parameters = [
            'fullPage' => true,
        ];

        $browsershot = $this->createMock(Browsershot::class);
        $browsershot->expects($this->exactly(1))->method('save');

        $browsershotFactory = $this->createMock(BrowsershotFactory::class);
        $browsershotFactory->expects($this->exactly(1))->method('create')->willReturn($browsershot);

        $logger = $this->createMock(LoggerInterface::class);

        $logger->expects($this->once())->method('info')
            ->with($this->anything());

        $em = $this->createMock(EntityManagerInterface::class);
        // mock return of dsn
        $em->method('getConnection')->willReturn('');

        $ScreenshotManager = new ScreenshotManager($parameterBag, $browsershotFactory, $logger, $em);

        $screenshot = $ScreenshotManager->execute($url, $parameters);

        $this->assertInstanceOf(Screenshot::class, $screenshot);
        $this->assertEquals($screenshot->getUrl(), $url);
        $this->assertNotEmpty($screenshot->getFilename());
        $this->assertNotEmpty($screenshot->getPath());
        $this->assertEquals($screenshot->getParameters(), $parameters);
    }

    public function testCreatesSameScreenshotRegardlessOfParameterOrder()
    {
        $this->markTestIncomplete();
    }
}
