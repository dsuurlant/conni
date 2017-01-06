<?php


namespace AppBundle\Command;


use AppBundle\Analyzer\RudeAnalyzer;
use AppBundle\Interpreter\Interpreter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DefaultCommand extends Command
{
    protected function configure()
    {
        $this
          ->setName('default')
          ->setDescription('C.O.N.I. version 3.14.15.9-beta');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // init validator

        $io = new SymfonyStyle($input, $output);
        $io->title('C.O.N.I. version 3.14.15.9-RC');
        $io->text(
          array(
            "Hello!",
            "I am your server's very own Console Operated Network Intelligence,",
            "but you can call me Conni.",
          )
        );

        $name = $io->ask("What is your name?");

        // Interpret user input.
        $ip = new Interpreter();
        $ip->addAnalyzer(new RudeAnalyzer());
        $ipResponse = $ip->interpret($name);

        // Response OK
        if ($ipResponse->getCode() === 200) {
            $text = $ipResponse->getMessage();
            $text[] = "Hello, ".$name."! It is nice to meet you.";
            $io->text($text);
        } else {
            // Response bad, bye
            if ($ipResponse->getCode() === 400) {
                $io->text($ipResponse->getMessage());
                // ragequit
                exit;
            }
        }
    }
}