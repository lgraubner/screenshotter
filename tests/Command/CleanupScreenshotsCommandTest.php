<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CleanupScreenshotsCommandTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:cleanup-screenshots');
        $commandTester = new CommandTester($command);
        $commandTester->execute([], [
            'days' => 100,
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Screenshot folder successfully cleaned', $output);

        // @TODO: mock?
        $this->markTestIncomplete();
    }
}
