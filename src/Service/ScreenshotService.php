<?php

namespace App\Service;

use Nesk\Puphpeteer\Puppeteer;

class ScreenshotService
{
    private $puppeteer;

    public function __construct()
    {
        $this->puppeteer = new Puppeteer();
    }

    public function screenshot(string $url)
    {
        // @TODO: fix
        $browser = $this->puppeteer->launch([
            'args' => ['--no-sandbox', '--disable-setuid-sandbox'],
        ]);

        $page = $browser->newPage();
        $page->goto($url);

        $page->screenshot([
            'path' => '/var/www/symfony/screenshot.png',
            'fullPage' => true,
        ]);

        $browser->close();
    }
}
