<?php

namespace App\Service;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class ClientService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(string $email): Client
    {
        $client = new Client();
        $client->setEmail($email);

        $uuid = Uuid::v4();
        $client->setApiKey(hash('sha256', $uuid));

        $this->em->persist($client);
        $this->em->flush();

        return $client;
    }
}
