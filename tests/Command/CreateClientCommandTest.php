<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Command\CreateClientCommand;
use App\Service\ClientService;
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
        // @TODO: mock em

        static::createKernel();

        $clientService = $this->createMock(ClientService::class);

        $command = new CreateClientCommand($clientService);
        $commandTester = new CommandTester($command);
        $commandTester->execute([], ['email' => 'foo@bar.de']);

        $this->assertEquals($commandTester->getStatusCode(), 0);
    }
}
