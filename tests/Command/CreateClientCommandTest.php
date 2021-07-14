<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use TypeError;

class CreateClientCommandTest extends KernelTestCase
{
    public function testRequiresEmail(): void
    {
        $this->expectError(TypeError::class);

        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:create-client');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);
    }

    public function testCreatesClient(): void
    {
        $this->markTestIncomplete();
        // @TODO: mock em

        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:create-client');
        $commandTester = new CommandTester($command);
        $commandTester->execute([], ['email' => 'foo@bar.de']);

        $this->assertEquals($commandTester->getStatusCode(), 0);
    }
}
