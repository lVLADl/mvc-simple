<?php


namespace App\System\Command\Database;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Migration extends \App\System\Command\Command {
    protected static $defaultName = 'app:migrate';
    public function execute(InputInterface $input, OutputInterface $output) {
        parent::execute($input, $output);

        $msg = new \App\System\Database\Migration();
        foreach($msg as $item) {
            $output->writeln($item);
        }

        $output->writeln('Migrations got successfully applied.');
        return Command::SUCCESS;
    }
}