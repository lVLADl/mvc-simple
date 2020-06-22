<?php


namespace App\System\Database;

use App\System\Database\Actions\Get;
use Tightenco\Collect\Support\Collection;
use App\System\Database\Actions\All;
use App\System\Database\Actions\Create;
use App\System\Database\Actions\Delete;
use App\System\Database\Actions\Update;
use App\System\Database\Actions\Where;
use Medoo\Medoo;

abstract class Model implements All, Create, Delete, Update, Where, Get {
    /*
     * DB-response-container
     *
     */
    public function __construct(array $args)
    {
        // TODO
        $bp_filled = self::blueprint(new Blueprint());
        foreach($bp_filled->asArray() as $field) {
           $field_name = $field->getName(); # -- key
           $this->$field_name = $args[$field_name]; # -- value
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
    public static abstract function all(): Collection;
    public static abstract function create(): Model;
    public static abstract function update(): Model;
    public static abstract function delete(): Model;
    public static abstract function where(): Collection;
    public static abstract function get(): Model;

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

    public static function my_fun()
    {
        return __CLASS__;
    }
}