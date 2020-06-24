<?php


namespace App\System\Command;


use App\Model\ExampleModel;
use App\System\Database\Blueprint;
use App\System\Database\Fields\BooleanField;
use App\System\Database\Fields\IntegerField;
use App\System\Database\Model;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tightenco\Collect\Support\Collection;

class TestCommand extends Command {
    protected static $defaultName = 'app:check';
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->model_instance_in_progress($input, $output);
        return Command::SUCCESS;
    }

    private function field_basics_finished() {
        $integer_field = new IntegerField('my_integer_field');
        # var_export($integer_field->system_convert_to_sql());


        $db = Model::system_db_connect();


        $boolean_field = new BooleanField('my_boolean_field', ['default' => true]);
        $boolean_field->setValue(False);
        #var_export($boolean_field->getValue());
        #var_export($boolean_field->system_convert_to_sql());

        print_r($integer_field->system_convert_to_sql());
        $db->create('testtest', [
            $integer_field->field_name => $integer_field->system_convert_to_sql(),
            # $boolean_field->system_convert_to_sql()
        ]);
        /*
        $str_field = new StringField('my_string_field', 100, ['default' => (string) 22, 'validators' => [
            function($value) {
                if($value == 'abcd') throw new \InvalidArgumentException('exc');
            },
            function($value) {
                # if($value === 'abc') throw new \InvalidArgumentException('exc' . __FUNCTION__);
            }
        ]]);
        $str_field->setValue('abc');


        var_export($str_field->system_convert_to_sql());
        */
    }
    private function query_finished(InputInterface $input, OutputInterface $output) {
        $query = new Collection([1, 2, 3, 'contraband']);
        $query->add(3);
        $query = $query->map(function($k, $v) {
            return $k . $v . "[]";
        });
        foreach($query as $value) {
            $output->writeln($value);
        }
    }
    private function model_finished(InputInterface $input, OutputInterface $output) {
        $models = config('models.models');
        foreach($models as $model_name => $model) {
            if(config('general.debug')) {
                var_export(forward_static_call([$model, 'create_table'], $model_name));
            } else {
                forward_static_call([$model, 'create_table'], $model_name);
            }
        }
    }

    public function model_instance_in_progress(InputInterface $input, OutputInterface $output) {
        $db = Model::system_db_connect();
        $model = ExampleModel::create([
            'message' => uniqid(),
            'my_name' => 'not default message'
        ]);


        # $this->is_published;
        foreach($model->fields as $field_name => $field_arr /* link to the object's specific field => it's class-field-instance */) {
            $value = $field_arr[0];
            print "[$field_name => $value]\n";
                    # -->   [message => 5ef3bad51400d]
                    # -->   [is_published => 1]
                    # -->   [date => 2020-06-23]
                    # -->   [my_name => not default message]

            # $model->is_published;
        }
    }
}