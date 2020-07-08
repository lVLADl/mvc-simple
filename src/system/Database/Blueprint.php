<?php


namespace App\System\Database;


use App\System\Database\Fields\Field;

class Blueprint implements \Iterator {
    private array $fields = [];
    private array $constraint = [];

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

        # Add unique-constraint
        if(isset($this->constraint)) {
            if(isset($this->constraint['unique'])) {
                foreach($this->constraint['unique'] as $unique_item) {
                    $medoo_columns[] = $unique_item;
                }
            }
        }
        return $medoo_columns;
    }

    public function add_unique(array $fields, string $constraint_name='') {
        if(!$constraint_name) {
            foreach($fields as $i => $field) {
                $constraint_name .= $field . (($i == array_key_last($fields))?'':'_');
            }
        }
        $unique = "CONSTRAINT $constraint_name UNIQUE (";
        foreach($fields as $i=>$field) {
            $unique .= $field . (($i==array_key_last($fields))?'':', ');
        }
        $this->constraint['unique'][] = $unique . ')';

        return $this;
    }


    public function set($key, $val)
    {
        $this->fields[$key] = $val;
    }

    public function get($key)
    {
        return $this->fields[$key];
    }

    public function current()
    {
        return current($this->fields);
    }

    public function key()
    {
        return key($this->fields);
    }

    public function next(): void
    {
        next($this->fields);
    }

    public function rewind(): void
    {
        reset($this->fields);
    }

    public function valid(): bool
    {
        return null !== key($this->fields);
    } # Iterable
}