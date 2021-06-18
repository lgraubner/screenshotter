<?php

namespace App\Service;

use App\Factory\BrowsershotFactory;
use App\Model\Screenshot;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;

class ScreenshotService
{
    private $parameterBag;
    private $browsershotFactory;

    public function __construct(ParameterBagInterface $parameterBag, BrowsershotFactory $browsershotFactory)
    {
        $this->parameterBag = $parameterBag;
        $this->browsershotFactory = $browsershotFactory;
    }

    public function execute(string $url): Screenshot
    {
        $filename = sprintf('%s.jpg', hash('sha256', $url));
        $screenshotDir = $this->parameterBag->get('screenshot_dir');

        $finder = new Finder();

        $path = sprintf('%s/%s', $screenshotDir, $filename);

        // @TODO: fill with options + url
        $screenshot = new Screenshot();
        $screenshot->setPath($path);

        $cacheTime = strtotime('-30 minutes');

        $finder->files()->in($screenshotDir)->name($filename)->date(sprintf('>= %s', date('Y-m-d', $cacheTime)));

        // @TODO: put vars in config?
        if (!$finder->hasResults()) {
            $browsershot = $this->browsershotFactory->create();
            // @TODO: pass screenshot in?

            $browsershot->setUrl($url)->save($path);
        }

        return $screenshot;
    }
}
