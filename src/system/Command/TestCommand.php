<?php


namespace App\System\Command;


use App\System\Database\Fields\IntegerField;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command {
    protected static $defaultName = 'app:check';
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $integer_field = new IntegerField('test_field', ['default' => 12, 'null' => false, 'try' => 2]);
        $output->writeln($integer_field->getProperties());
        var_export($integer_field->system_convert_to_sql());
        return Command::SUCCESS;
    }
}