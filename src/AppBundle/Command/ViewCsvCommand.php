<?php


namespace AppBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ViewCsvCommand extends ConniCommand
{
    protected function configure()
    {
        $this
          ->setName('View CSV')
          ->setDescription('Specify a CSV file to view.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('View CSV');

        // Find CSV files in the application
        $finder = new Finder();
        $finder->files()->in(__DIR__.'/../../')->name('*.csv');
        $options = array();
        foreach ($finder as $file) {
            $options[] = $file->getRealPath();
        }

        $answer = $io->choice(
          "Which CSV file would you like to view, ".$this->getUsername()."?",
          $options
        );

        $csv = file($answer);

        // @TODO validate CSV
        // @TODO output to table
        // @TODO pagination?
    }
}