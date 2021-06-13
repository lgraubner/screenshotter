<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class CleanupScreenshotsCommand extends Command
{
    protected static $defaultName = 'app:cleanup-screenshots';
    protected static $defaultDescription = 'Cleans screenshot folder removing files older than specified day threshold.';

    const DEFAULT_DAYS = 30;

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
            ->addOption('days', 'd', InputOption::VALUE_OPTIONAL, 'Threshold of days to keep screenshots in days', self::DEFAULT_DAYS)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $days = $input->getOption('days');
        $screenshotDir = $this->parameterBag->get('screenshot_dir');

        $threshold = strtotime(sprintf('-%d days', $days));

        $finder = new Finder();
        $finder->files()->in($screenshotDir)->date(sprintf('<= %s', date('Y-m-d', $threshold)));

        $count = $finder->count();

        if ($finder->hasResults()) {
            $filesystem = new Filesystem();
            $filesystem->remove($finder->getIterator());
        }

        $io->success(sprintf('Screenshot folder successfully cleaned. Removed %d files.', $count));

        return Command::SUCCESS;
    }
}
