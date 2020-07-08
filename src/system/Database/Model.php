<?php


namespace App\System\Database;

use App\System\Database\Actions\Get;
use App\System\Database\Fields\Field;
use App\System\Database\Fields\OneToManyRelationField;
use App\System\Database\Fields\RelationField;
use App\System\Database\Fields\UpdatedAtField;
use App\System\Exceptions\DbRowNotFound;
use App\System\Exceptions\ValidationFailed;
use Carbon\Carbon;
use Tightenco\Collect\Support\Collection;
use App\System\Database\Actions\All;
use App\System\Database\Actions\Create;
use App\System\Database\Actions\Delete;
use App\System\Database\Actions\Update;
use App\System\Database\Actions\Where;
use Medoo\Medoo;


/*
 * Almost done, but there are some more things to work out:
 *  1 - Exceptions-handling: ~10%
 *  2 - Planned functionality: ~98%
 *      The custom model takes about 20 lines of code,
 *      I think, this is awesome and that's what I was
 *      trying to achieve: minimum of required code
 *
 *      1 - add some more functions:
 *          [] toString
 *          [] ...
 *  3 - Refactoring: ~80%
 *  4 - Fields:
 *      1 - add more fields: ~60%
 *      2 - add more parameters like index, ...
 *  5 - Explanation:
 *      1 - add more comments, examples for those,
 *          who will be reviewing this code (rather for the interview,
 *          I don't think that anybody will be interested to use this
 *          "framework") ~50%
 *      2 - remove some of the unnecessary comments (like this one and
 *          the previous one ~96%
 *
 */

abstract class Model implements All, Create, Delete, Update, Where, Get {
    public static string $model_name;

    public array $fields = [];

    # Called by the methods like: all, where, ...
    # Should't be created manually outside of the class's-environment
    private final function __construct(array $args)
    {
        $bp = static::blueprint(new Blueprint);
        foreach($bp as $field) {
            $field_name = $field->field_name;

            if($field instanceof RelationField) {
                $this->$field_name = ($field->related_class)::get($args[$field_name]);
            } else {
                $this->$field_name = $args[$field_name];
            }

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
            if((!($field_object->null)) and !($field_object->default) and !($field_object->auto_increment)) {
                $required[$field_name] = $field_object;
            }
        }

        return $required;
    }

    public static function get_updated_at_field_name() {
        $updated_at = null;
        foreach(static::blueprint(new Blueprint()) as $field_name => $field_object) {
            if($field_object instanceof UpdatedAtField) {
                return $field_object->field_name;
            }
        }

        return;
    }

    public static function get_primary_key_field(): Field {
        foreach (static::blueprint(new Blueprint()) as $key => $value) {
            if($value->primary_key) {
                return $value;
            }
        }
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
    /* TODO */
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

    // TODO
    protected function attach_related_rows(Model $model_instance) {
        $fks = $model_instance->get_foreign_keys();
        foreach($fks as $key);
    }
    public static function get_foreign_keys(): array {
        return array_filter(static::get_fields(), function($field_instance) {
            return $field_instance instanceof RelationField;
        });
    }

    # uses get
    public static function create($args) {
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
            $msg = "\nThis fields are also required: [";
            foreach($required_fields as $key => $field) {
                $delimiter = (($key===array_key_last($required_fields))?'':', ');
                $msg .= $field->field_name . $delimiter;
            }

            throw new ValidationFailed($msg . ']');
        }
    }

    # uses get
    public function update(array $update_arr) {
        if($updated_at_field_arr = static::get_updated_at_field_name()) {
            $update_arr[$updated_at_field_arr] = Carbon::now()->toDateTimeString();
        }

        /* TODO: validation, exceptions-handling*/
        static::system_db_connect()->update(static::$model_name, $update_arr, $this->toArray());
        /* Call to the get_primary_key_field() to use it's value in the next static::get call */
        $pk_field_name = static::get_primary_key_field()->field_name;
        /* Fetch row from the database to actualize the columns in the objects */
        $update_arr = static::get($this->$pk_field_name);
        /* Update current instance */
        foreach($update_arr as $key=>$value) {
            $this->$key = $value;
        }
    }

    public function delete() {
        $pk_field_name = static::get_primary_key_field()->field_name;
        $pk_field_value = $this->$pk_field_name;

        static::system_db_connect()->delete(static::$model_name, [
            $pk_field_name => $pk_field_value
        ]);
    }

    /*
     * Temporary postponed due to some reasons:
     *  1 - Requires a big amount of time to implement filtering- functionality
     *  2 - The result is already available in Collections, the only reason is that
     *      all the data is fetched from the db and after that, filtering is going
     *      (in case of using Collection's- functions).
     *
     *  TODO: Add where- filtering
     */
    public static abstract function where(): Collection;

    public static function get($id) {
        /* If row isn't fetched from the db, the exception should be raised */
        $db_record = static::system_db_connect()->get(static::$model_name, '*', [
            static::get_primary_key_field()->field_name => $id
        ]);

        $model_instance = null;
        if($db_record) {
            $model_instance = new static($db_record);
        }

        if(!$model_instance) {
            throw new DbRowNotFound('Row not found in the database');
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

    public function toArray(): array {
        $out_arr = [];
        foreach ($this->fields as $field_name => $field_arr) {
            $field_value = $field_arr[0];
            $field_object = $field_arr[1];

            $out_arr[$field_name] = $field_value;
        }

        return $out_arr;
    }

    public function __toString()
    {
        return static::$model_name . " [$this->id]";
    }
}