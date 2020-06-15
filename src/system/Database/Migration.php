<?php


namespace App\System\Database;


class Migration {
    private $db;
    public function __construct() {
        global $database;
        $this->db = $database;

        $out = [];

        $create_table = $this->create_migration_tables();
        if($create_table->errorCode()) {
            $out[] = $create_table->errorInfo();
        } else {
            $out[] = "migration_tables got successfully created";
        }
    }

    private function create_migration_tables() {
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
    }
}