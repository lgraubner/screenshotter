<?php

namespace App\Factory;

use Spatie\Browsershot\Browsershot;

class BrowsershotFactory
{
    public function create($url): Browsershot
    {
        return Browsershot::url($url)
            ->setChromePath('/usr/bin/chromium')
            ->noSandbox()
            ->setScreenshotType('jpeg', 70)
            ->windowSize(1200, 800)
            ->dismissDialogs()
            ->waitUntilNetworkIdle();
    }
}
