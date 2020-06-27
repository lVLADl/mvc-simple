<?php


namespace App\System\Command;


use App\Model\ExampleModel;
use App\Model\UserModel;
use App\System\Database\Blueprint;
use App\System\Database\Fields\BooleanField;
use App\System\Database\Fields\CreatedAtField;
use App\System\Database\Fields\DateTimeField;
use App\System\Database\Fields\IntegerField;
use App\System\Database\Fields\UpdatedAtField;
use App\System\Database\Model;
use Carbon\Carbon;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tightenco\Collect\Support\Collection;

class TestCommand extends Command {
    protected static $defaultName = 'app:check';
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        print $this->register() . "\n";
        # $this->user_get();

//        print $model = UserModel::get('user@gmail.com');
//        var_export($model->authorize('user'));

        # print env('SECRET_KEY');
        return Command::SUCCESS;
    }

    /* User */
    public function register() {
        $user = UserModel::register([
            'email' => 'user@gmail.com',
            'password' => 'user',
        ]);

        return $user;
    }
    public function user_get() {
        $users = UserModel::all();
        foreach($users as $user) {
            print $user . ' ' . $user->password;
            print "\n";
        }
    }

    private function __field_basics_finished() {
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
    private function __query_finished() {
        $query = new Collection([1, 2, 3, 'contraband']);
        $query->add(3);
        $query = $query->map(function($k, $v) {
            return $k . $v . "[]";
        });
        foreach($query as $value) {
            print $value;
        }
    }
    private function __model_finished() {
        $models = config('models.models');
        foreach($models as $model_name => $model) {
            if(config('general.debug')) {
                var_export(forward_static_call([$model, 'create_table'], $model_name));
            } else {
                forward_static_call([$model, 'create_table'], $model_name);
            }
        }
    }

    /* Create instance and print the result */
    public function model_create() {
        $db = Model::system_db_connect();
        $model = ExampleModel::create([
            'message' => uniqid(),
            'my_name' => 'not default message'
        ]);


        foreach($model->fields as $field_name => $field_arr /* link to the object's specific field: [field-value => it's class-field-instance] */) {
            $value = $field_arr[0];
            print "[$field_name => $value]\n";
                    # -->   [message => 5ef3bad51400d]
                    # -->   [is_published => 1]
                    # -->   [date => 2020-06-23]
                    # -->   [my_name => not default message]

            # $model->is_published;
        }
    }
    /* Fetch all the records and print them one by one */
    public function model_all() {
        return ExampleModel::all();
    }
    /* Beautiful printing and toArray-method usage example */
    public function print_example_model(ExampleModel $model) {
        print "[\n";
        foreach($arr = $model->toArray() as $f_name => $f_val) {
            print " $f_name => $f_val;". (array_key_last($arr)==$f_name?'':"\n");
        }
        print "\n]";
    }
    public function update() {
        $model=ExampleModel::get(1);
        print "Before::";
        $this->print_example_model($model);
        $model->update([
            'message' => 'it\'s working 100% properly and yes and yes'
        ]);

        print "\nAfter::";
        $this->print_example_model($model);
    }
    public function delete() {
        $model = ExampleModel::get(2);
        if($model) {
            $model->delete();
        }
        foreach($this->model_all() as $model) {
            $this->print_example_model($model);
            print "\n";
        }
    }

    /* Usage-examples */

    /* Fetch all model rows, then update them and print in a beautiful way */
    function model_all__update() {
        foreach($this->model_all() as $model) {
            $model->update([
                'message' => 'custom message (upd. ' . $model->id . ')'
            ]);
            $this->print_example_model($model);
        }
    }
}