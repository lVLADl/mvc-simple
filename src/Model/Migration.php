<?php


namespace App\Model;


class Migration {
    public function __construct() {
        global $database;
        
        /*
        $database->create("migration_tables", [
            "id" => [
                "INT",
                "NOT NULL",
                "AUTO_INCREMENT",
                "PRIMARY KEY"
            ],
            "table_name" => [
                "VARCHAR(30)",
                "NOT NULL"
            ]
        ]);
        */
    }
}