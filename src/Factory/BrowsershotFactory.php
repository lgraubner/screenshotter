<?php

namespace App\Factory;

use Spatie\Browsershot\Browsershot;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class BrowsershotFactory
{
    private $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function create(string $url, $parameters = []): Browsershot
    {
        $defaults = $this->parameterBag->get('defaults');

        $options = array_merge($defaults, $parameters);

        $chromeBinaryPath = $this->parameterBag->get('chrome_binary_path');
        $noSandbox = $this->parameterBag->get('no_sandbox');

        $browsershot = Browsershot::url($url)
            ->setScreenshotType('jpeg', $options['quality'])
            ->windowSize($options['width'], $options['height'])
            ->dismissDialogs()
            ->waitUntilNetworkIdle();

        if ($chromeBinaryPath) {
            $browsershot->setChromePath($chromeBinaryPath);
        }

        if (is_bool($noSandbox)) {
            $browsershot->noSandbox();
        }

        if ($options['fullPage']) {
            $browsershot->fullPage();
        }

        if ($options['delay'] > 0) {
            $browsershot->setDelay($options['delay']);
        }

        return $browsershot;
    }
}
