<?php


namespace App\System\Database;


/*
 * This class isn't finished yet: todo: migrations-feature will be implemented in future
 * For now, each time migration-command gets called, tables get rewritten.
 * Nevertheless, it's just a simple MVC- framework :3
 */
class Migration {
    private $db;
    public function __construct() {
        global $database;
        $this->db = $database;

        $out = [];

        $create_table = $this->create_migration_tables();
        if($create_table) {
            if($create_table->errorCode()) {
                $out[] = $create_table->errorInfo();
            } else {
                $out[] = "migration_tables got successfully created";
            }
        } # -- ToDo: migration_tables
    }

    /*  NOT IMPLEMENTED FUNCTION: TODO IN FUTURE
     * private function create_migration_tables() {
        return $this->db->create("migration_tables", [
            "table_name" => [
                "VARCHAR(500)",
                "PRIMARY KEY"
            ],
            "created_at" => [
                "TIMESTAMP",
                "DEFAULT CURRENT_TIMESTAMP"
            ]
        ]);
    }*/

    public function __call($name, $arguments) { }
}