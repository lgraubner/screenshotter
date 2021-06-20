<?php

namespace App\Service;

use App\Factory\BrowsershotFactory;
use App\Model\Screenshot;
use Psr\Log\LoggerInterface;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;

class ScreenshotService
{
    private $parameterBag;
    private $browsershotFactory;
    private $logger;

    public function __construct(ParameterBagInterface $parameterBag, BrowsershotFactory $browsershotFactory, LoggerInterface $screenshotLogger)
    {
        $this->parameterBag = $parameterBag;
        $this->browsershotFactory = $browsershotFactory;
        $this->logger = $screenshotLogger;
    }

    /**
     * @param string $url
     * @return Screenshot
     * @throws CouldNotTakeBrowsershot
     */
    public function execute(string $url): Screenshot
    {
        // @TODO: take options into account for filename?
        $filename = sprintf('%s.jpg', hash('sha256', $url));
        $screenshotDir = $this->parameterBag->get('screenshot_dir');

        $finder = new Finder();

        $path = sprintf('%s/%s', $screenshotDir, $filename);

        // @TODO: fill with options
        $screenshot = new Screenshot($url);
        $screenshot->setPath($path);
        $screenshot->setFileName($filename);

        $cacheTime = strtotime('-30 minutes');

        $finder->files()->in($screenshotDir)->name($filename)->date(sprintf('>= %s', date('Y-m-d', $cacheTime)));

        if (!$finder->hasResults()) {
            // @TODO: pass in options from config
            $browsershot = $this->browsershotFactory->create($url);

            $browsershot->save($path);

            $this->logger->info(sprintf('Screenshot for %s created at %s.', $url, $path));
        }

        return $screenshot;
    }
}
