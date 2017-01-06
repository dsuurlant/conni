<?php


namespace AppBundle\Command;


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
        $io->text("Hello, ".$name."! It is nice to meet you.");
    }
}