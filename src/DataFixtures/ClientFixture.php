<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class ClientFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $client = new Client();
        $client->setEmail('yummy@pizza.land');

        $uuid = Uuid::v4();
        $client->setApiKey(hash('sha256', (string) $uuid));

        $manager->persist($client);

        $manager->flush();
    }
}
