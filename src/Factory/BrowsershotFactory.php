<?php

namespace App\Factory;

use Spatie\Browsershot\Browsershot;

class BrowsershotFactory
{
    public function create(): Browsershot
    {
        return (new Browsershot())
            ->noSandbox()
            ->setScreenshotType('jpeg', 70)
            ->windowSize(1200, 800)
            ->dismissDialogs()
            ->waitUntilNetworkIdle();
    }
}
