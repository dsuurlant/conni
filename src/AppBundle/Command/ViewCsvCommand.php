<?php


namespace AppBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use League\Csv\Reader;

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

        $csv = Reader::createFromPath($answer);
        $headers = $csv->fetchOne();

        $limit = 25;
        $currentPage = 0;
        $totalRows = count($csv->fetchAll());
        $totalPages = round($totalRows / $limit);
        $io->table($headers, $csv->setOffset(1)->setLimit($limit)->fetchAll());

        $nav = array(
          "First page",
          "Previous page",
          "Next page",
          "Last page",
          "View another CSV",
          "Go back to the previous menu",
        );

        $runningViewer = true;
        // default to staying with this command.
        $newCommand = "View CSV";
        while ($runningViewer) {
            $navAnswer = $io->choice("What would you like to do next?", $nav);

            switch ($navAnswer) {
                case $nav[0]:
                    // First page
                    $io->table($headers, $csv->setOffset(1)->setLimit($limit)->fetchAll());
                    break;
                case $nav[1]:
                    // Previous page
                    if ($currentPage === 0) {
                        $io->text("You're on the first page, ".$this->getUsername().".");
                        $io->table($headers, $csv->setOffset(1)->setLimit($limit)->fetchAll());
                    } else {
                        $nextOffset = (($currentPage * $limit) - $limit) + 1;
                        $io->table(
                          $headers,
                          $csv->setOffset($nextOffset)->setLimit($limit)->fetchAll()
                        );
                        $currentPage--;
                    }
                    break;
                case $nav[2]:
                    // Next page
                    if ($currentPage == ($totalPages - 1)) {
                        $io->text("You're on the last page, ".$this->getUsername().".");
                        $io->table($headers, $csv->setOffset(($totalRows - $limit) + 1)->setLimit($limit)->fetchAll());
                    } else {
                        $nextOffset = (($currentPage * $limit) + $limit) + 1;
                        $io->table(
                          $headers,
                          $csv->setOffset($nextOffset)->setLimit($limit)->fetchAll()
                        );
                        $currentPage++;
                    }
                    break;
                case $nav[3]:
                    // Last page
                    $io->table($headers, $csv->setOffset(($totalRows - $limit) + 1)->setLimit($limit)->fetchAll());
                    break;
                case $nav[4]:
                    // View another CSV, so break out of loop
                    $runningViewer = false;
                    break;
                case $nav[5]:
                    // Go back to the previous menu
                    $newCommand = "default";
                    $runningViewer = false;
                    break;
                default:
                    $runningViewer = false;
            }
        }

        // Viewing CSV file has ended, run specified next command.
        $comm = $this->getApplication()->find($newCommand);
        $comm->setUsername($this->getUsername());
        $comm->run(new ArrayInput(array()), $output);

    }
}