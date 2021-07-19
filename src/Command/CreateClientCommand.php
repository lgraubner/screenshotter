<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\ClientService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
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
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $helper = $this->getHelper('question');

        $question = new Question('Client\'s email address: ');
        $question->setValidator(function ($answer) {
            if (null === $answer || !preg_match('/.+@.+/', $answer)) {
                throw new \RuntimeException('Invalid email');
            }

            return $answer;
        });
        $question->setMaxAttempts(3);

        $email = $helper->ask($input, $output, $question);

        $client = $this->clientService->create($email);

        $io->success(sprintf('Created client with email %s and api key "%s".', $client->getEmail(), $client->getApiKey()));

        return Command::SUCCESS;
    }
}
