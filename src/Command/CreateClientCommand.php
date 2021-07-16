<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\ClientService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateClientCommand extends Command
{
    protected static $defaultName = 'app:create-client';
    protected static $defaultDescription = 'Creates a new api client.';

    private ClientService $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addOption('email', null, InputOption::VALUE_REQUIRED, 'Contact email')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $client = $this->clientService->create($input->getOption('email'));

        $io->success(sprintf('Created client with email %s and api key "%s".', $client->getEmail(), $client->getApiKey()));

        return Command::SUCCESS;
    }
}
