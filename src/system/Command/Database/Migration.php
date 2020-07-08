<?php


namespace App\System\Command\Database;

use App\Model\Role;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Migration extends \App\System\Command\Command {
    protected static $defaultName = 'app:migrate';
    public function execute(InputInterface $input, OutputInterface $output) {
        $models = config('models.models');
        $errors = [];

        /* Apply migrations */
        foreach($models as $model_name => $model) {
            $result = forward_static_call([$model, 'create_table'], $model_name);
            if($result->errorInfo()[0] != 00000) {
                $errors[] = $result->errorInfo()[2];
            }
        }

        /* Basic seeds */
        Role::create([
            'role_name' => 'Admin',
        ]);
        Role::create([
            'role_name' => 'User'
        ]);

        // TODO: fix the not-working system
        if(sizeof($errors)) {
            for($i=0; $i<sizeof($errors)-1; $i++) {
                $output->writeln($errors[$i]);
            }
            return Command::FAILURE;
        } else {
            $output->writeln('Migrations got successfully applied.');
            return Command::SUCCESS;
        }
    }
}