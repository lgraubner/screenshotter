<?php

declare(strict_types=1);

namespace App\Tests\Controller\Api;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ScreenshotControllerTest extends WebTestCase
{
    public function testRequiresAuthorization(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/screenshot');

        $this->assertResponseStatusCodeSame(401);
    }

    public function testInvalidPayload(): void
    {
        $client = static::createClient();

        $appClients = self::getContainer()->get('doctrine')->getRepository(Client::class)->findAll();

        $client->request('GET', '/api/v1/screenshot', [], [], [
            'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $appClients[0]->getApiKey()),
        ]);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testCreatesScreenshot(): void
    {
        $client = static::createClient();

        $appClients = self::getContainer()->get('doctrine')->getRepository(Client::class)->findAll();

        $client->request('GET', '/api/v1/screenshot?url=https://heise.de', [], [], [
            'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $appClients[0]->getApiKey()),
        ]);

        $this->assertResponseIsSuccessful();
    }
}
