<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class CleanupScreenshotsCommand extends Command
{
    protected static $defaultName = 'app:screenshot:cleanup';
    protected static $defaultDescription = 'Removes expired screenshots.';

    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;

    public function __construct(ParameterBagInterface $parmeterBag)
    {
        $this->parameterBag = $parmeterBag;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $cacheDuration = $this->parameterBag->get('cache_duration');
        $screenshotDir = $this->parameterBag->get('screenshot_dir');

        $threshold = strtotime(sprintf('-%s minutes', $cacheDuration));

        $finder = new Finder();
        $finder->files()->in($screenshotDir)->date(sprintf('<= %s', date('Y-m-d H:i:s', $threshold)));

        $count = $finder->count();

        if ($finder->hasResults()) {
            $filesystem = new Filesystem();
            $filesystem->remove($finder->getIterator());
        }

        $io->success(sprintf('Screenshot folder successfully cleaned. Removed %d files.', $count));

        return Command::SUCCESS;
    }
}
