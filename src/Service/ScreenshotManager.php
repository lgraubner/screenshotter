<?php

namespace App\Service;

use App\Factory\BrowsershotFactory;
use App\Model\Screenshot;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\Cache\Adapter\PdoAdapter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ScreenshotManager
{
    private $parameterBag;
    private $browsershotFactory;
    private $logger;
    private $em;

    public function __construct(ParameterBagInterface $parameterBag, BrowsershotFactory $browsershotFactory, LoggerInterface $screenshotLogger, EntityManagerInterface $em)
    {
        $this->parameterBag = $parameterBag;
        $this->browsershotFactory = $browsershotFactory;
        $this->logger = $screenshotLogger;
        $this->em = $em;
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function execute(string $url, $parameters = []): Screenshot
    {
        $screenshotDir = $this->parameterBag->get('screenshot_dir');
        $cacheDuration = $this->parameterBag->get('cache_duration');

        $filename = $this->getFilename($url, $parameters);

        $cache  = new PdoAdapter($this->em->getConnection());

        $logger = $this->logger;

        $screenshot = $cache->get($filename, function (ItemInterface $item) use ($cacheDuration, $url, $screenshotDir, $filename, $parameters, $logger) {
            $item->expiresAfter($cacheDuration);

            $path = sprintf('%s/%s', $screenshotDir, $filename);

            $screenshot = new Screenshot($url, $parameters);
            $screenshot->setFilename($filename);
            $screenshot->setPath($path);

            $browsershot = $this->browsershotFactory->create($url, $parameters);

            $browsershot->save($path);

            $logger->info(sprintf('Screenshot for %s created at %s.', $url, $path));

            return $screenshot;
        });

        return $screenshot;
    }

    private function getFilename(string $url, array $parameters, $ext = 'jpg'): string
    {
        // sort to make sure only one screenshot per parameter combination is created
        ksort($parameters);

        $filenameData = sprintf('%s_%s', $url, json_encode($parameters));

        return sprintf('%s.%s', hash('sha256', $filenameData), $ext);
    }
}
