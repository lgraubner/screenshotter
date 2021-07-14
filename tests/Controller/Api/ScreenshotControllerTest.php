<?php

namespace App\Tests\Controller\Api;

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
        // @TODO: test db, fixture
        // @TODO: authorization required
        $this->markTestIncomplete();
        $client = static::createClient();
        $client->request('GET', '/api/v1/screenshot', [
            'headers' => [
                'Authorization' => 'Bearer XXX'
            ]
        ]);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testCreatesScreenshot(): void
    {
        $this->markTestIncomplete();
        $client = static::createClient();
        // @TODO: use json request
        $client->request('GET', '/api/v1/screenshot?url=https://google.com');

        $this->assertResponseIsSuccessful();
    }
}
