<?php

namespace App\Service;

use Spatie\Browsershot\Browsershot;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;

class ScreenshotService
{
    private $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function execute(string $url)
    {
        $filename = sprintf('%s.jpg', hash('sha256', $url));
        $screenshotDir = $this->parameterBag->get('screenshot_dir');

        $finder = new Finder();

        $path = sprintf('%s/%s', $screenshotDir, $filename);

        $cacheTime = strtotime('-30 minutes');

        $finder->files()->in($screenshotDir)->name($filename)->date(sprintf('>= %s', date('Y-m-d', $cacheTime)));

        // @TODO: put vars in config
        if (!$finder->hasResults()) {
            Browsershot::url($url)->noSandbox()->setScreenshotType('jpeg', 70)->windowSize(1200, 800)->dismissDialogs()->waitUntilNetworkIdle()->save($path);
        }

        return $path;
    }
}
