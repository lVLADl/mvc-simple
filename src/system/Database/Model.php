<?php


namespace App\System\Database;

use App\System\Database\Actions\Get;
use App\System\Database\Fields\Field;
use Tightenco\Collect\Support\Collection;
use App\System\Database\Actions\All;
use App\System\Database\Actions\Create;
use App\System\Database\Actions\Delete;
use App\System\Database\Actions\Update;
use App\System\Database\Actions\Where;
use Medoo\Medoo;

abstract class Model implements All, Create, Delete, Update, Where, Get {
    public static string $model_name;

    /*
     * DB-response-container
     * TODO: in-progress-№1
     */
    public array $fields = [];

    # Called by the methods like: all, where, ...
    private final function __construct(array $args)
    {
        $bp = static::blueprint(new Blueprint);
        foreach($bp as $field) {
            $field_name = $field->field_name;

            $this->$field_name = $args[$field_name];

            # Link to the field: did it because all of the models are different, so this array keeps
            # all the links to fields; this also allows this model to be iterable
            $this->fields[$field_name] = [&$this->$field_name, $field];
        }
    }

    # TODO: refactor constructor to use this method
    public static function get_fields(): array {
        return iterator_to_array(static::blueprint(new Blueprint()), true);
    }
    public static function get_required_fields(): array {
        $required = [];
        foreach(static::blueprint(new Blueprint()) as $field_name => $field_object) {
            if((!($field_object->null)) and !($field_object->default)) {
                $required[$field_name] = $field_object;
            }
        }

        return $required;
    }
    public static function get_primary_key_field() {
        foreach (static::blueprint(new Blueprint()) as $key => $value) {
            if($value->primary_key) {
                return $value;
            }
        }

        return null;
    }


    /*
     * Static tools for fetching data from the db
     * Static tools for creating table from blueprint
     *
     */


    # Fetches connection from globals
    public static function system_db_connect(): Medoo {
        return $GLOBALS['database'];
    }

    # All the function manages CRUD with the table in the database
    # via Medoo- package
    public static function all(): Collection {
        $db = static::system_db_connect();
        $db_records = $db->select(static::$model_name, '*');
        $collection = new Collection();
        if($db_records) {
            foreach($db_records as $record) {
                $collection->add(new static($record));
            }
        }

        return $collection;
    }

    public static function create($args): Model {
        $db = static::system_db_connect();
        $constructor_args = [];
        $required_fields = static::get_required_fields();

        foreach(static::get_fields() as $field_name => $field_object) {
            if(isset($args[$field_name])) {
                $field_value =  $args[$field_name];
                $field_object->validate($field_value);
                $constructor_args[$field_name] = $field_value;
                unset($required_fields[$field_name]);
            }
        }

        if(sizeof($required_fields) == 0) {
            $db->insert(static::$model_name, $constructor_args);
            $row = $db->get(static::$model_name, '*', $constructor_args);

            return new static($row);
        } else {
            /* TODO: it should be a specific ValidationException */
            /* TODO: create special exceptions, add handling-system, divide them by the level: ~[info, debug, lite, medium, alert, ...] */
            $msg = "\nThis fields are also required: [";
            foreach($required_fields as $key => $field) {
                $delimiter = (($key===array_key_last($required_fields))?'':', ');
                $msg .= $field->field_name . $delimiter;
            }
            print  $msg . ']';
        }
    }

    public static abstract function update(): Model;
    public static abstract function delete(): Model;
    public static abstract function where(): Collection;
    public static function get($id): Model {
        /* If row isn't fetched from the db, the exception should be raised */
        $db_record = static::system_db_connect()->get(static::$model_name, '*', [
            'id' => $id
        ]);

        $model_instance = null;
        if($db_record) {
            $model_instance = new static($db_record);
        }
        return $model_instance;
    }

    # <REWRITABLE>
    # This is where all the columns are declared
    public static function blueprint(Blueprint $empty_blueprint) {
        return null;
    }

    # Respond for a command
    public static function create_table(string $table_name) {
        $db = static::system_db_connect();
        $blueprint = static::blueprint(new Blueprint());

        /*
         * Save to the database
         *
         */
        $db->drop($table_name);
        $db_result = $db->create($table_name, $blueprint->to_medoo_format());

        return $db_result;
    }

    public function __toString()
    {
        return static::$model_name . " [$this->id]";
    }
}