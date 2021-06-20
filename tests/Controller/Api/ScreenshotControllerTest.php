<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ScreenshotControllerTest extends WebTestCase
{
    public function testInvalidPayload(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/screenshot');

        $this->assertResponseStatusCodeSame(400);
    }

    public function testCreatesScreenshot(): void
    {
        $client = static::createClient();
        // @TODO: use json request
        $client->request('GET', '/api/v1/screenshot?url=https://google.com');

        $this->assertResponseIsSuccessful();
    }
}
