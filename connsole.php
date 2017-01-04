<?php

require_once('/vendor/autoload.php');

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

$app = new Application();

$app->register('hello')->setHelp('Say hello!')->setCode(
  function (InputInterface $input, OutputInterface $output) {
      $output->writeln('Hello, world.');
  }
);

$app->run();
