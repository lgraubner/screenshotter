<?php

namespace App\Command;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Uid\Uuid;

class CreateClientCommand extends Command
{
    protected static $defaultName = 'app:create-client';
    protected static $defaultDescription = 'Creates a new api client.';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

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

        $client = new Client();
        $client->setEmail($input->getOption('email'));

        $uuid = Uuid::v4();
        $client->setApiKey(hash('sha256', $uuid));

        $this->em->persist($client);
        $this->em->flush();

        $io->success(sprintf('Created client with email %s and api key "%s".', $client->getEmail(), $client->getApiKey()));

        return Command::SUCCESS;
    }
}
