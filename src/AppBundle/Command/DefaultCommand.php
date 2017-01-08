<?php


namespace AppBundle\Command;


use AppBundle\Analyzer\RudeAnalyzer;
use AppBundle\Interpreter\Interpreter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

class DefaultCommand extends Command
{
    protected function configure()
    {
        $this
          ->setName('default')
          ->setDescription('Default Conni application');
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

        // Interpret user input.
        $ip = new Interpreter();
        $ip->addAnalyzer(new RudeAnalyzer());
        $ipResponse = $ip->interpret($name);

        // Response OK
        if ($ipResponse->getCode() === 200) {
            $text = $ipResponse->getMessage();
            $io->text("Hello, ".$name."! It is nice to meet you.");
            // @TODO save name to Conni session.
        } else {
            // Response bad, bye
            if ($ipResponse->getCode() === 400) {
                $io->text($ipResponse->getMessage());
                // ragequit
                exit;
            }
        }

        // List available commands
        $commands = $this->getApplication()->all();
        $commandOptions = array();
        foreach ($commands as $command) {
            if ($command instanceof ConniCommand) {
                $commandOptions[$command->getName()] = $command->getDescription();
            }
        }
        if (count($commandOptions) > 0) {
            $choice = $io->choice("What can I do for you today?", $commandOptions);

            // Launch chosen command.
            $io->text("Your wish is my command, ".$name."!");
            $chosenCommand = $this->getApplication()->find($choice);
            $chosenCommand->setUsername($name);
            $commandOutput = $chosenCommand->run(new ArrayInput(array()), $output);
        } else {
            $io->text(
              array(
                "I currently have no commands available, I'm sorry.",
                "You should get in touch with my programmers, and ask them if they can improve my usefulness.",
              )
            );
        }
    }
}