<?php


namespace App\System\Database;


use App\System\Database\Fields\Field;

class Blueprint {
    private array $fields;

    public function __construct() { }
    public function add_field(Field $field) {
        # TODO: Validate field: whether name is already used, ...
        $this->fields[$field->field_name] = $field;
        return $this;
    }
    public function to_medoo_format(): array {
        $medoo_columns = [];
        foreach($this->fields as $field_name => $field) {
            $medoo_columns[$field_name] = $field->system_convert_to_sql()[$field_name];
        }
        return $medoo_columns;
    }
}