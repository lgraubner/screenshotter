<?php

declare(strict_types=1);

namespace App\Factory;

use Spatie\Browsershot\Browsershot;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class BrowsershotFactory
{
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    /**
     * @param array<string, mixed> $parameters
     */
    public function create(string $url, array $parameters = []): Browsershot
    {
        $defaults = $this->parameterBag->get('defaults');

        $options = array_merge($defaults, $parameters);

        $noSandbox = $this->parameterBag->get('no_sandbox');

        $browsershot = Browsershot::url($url)
            ->setScreenshotType('jpeg', $options['quality'])
            ->windowSize($options['width'], $options['height'])
            ->dismissDialogs()
            ->waitUntilNetworkIdle();

        // $this->parameterBag->get('chrome_binary_path')
        //if ($chromeBinaryPath) {
        //    $browsershot->setChromePath($chromeBinaryPath);
        //}

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
