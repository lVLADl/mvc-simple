<?php


namespace App\System\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Command extends \Symfony\Component\Console\Command\Command {
    protected function execute(InputInterface $input, OutputInterface $output) { }
}