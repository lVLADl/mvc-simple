<?php


namespace App\System\Database;


use App\System\Database\Fields\Field;

class Blueprint implements \Iterator {
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