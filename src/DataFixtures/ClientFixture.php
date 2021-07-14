<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class ClientFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setEmail('yummy@pizza.land');

        $uuid = Uuid::v4();
        $client->setApiKey(hash('sha256', $uuid));

        $manager->persist($client);

        $manager->flush();
    }
}