<?php


namespace App\System\Database\Fields;

abstract class RelationField extends Field {
    public Field $related_field;

    public $type;
    public string $max_length;
    public function convert_value($value)
    {
        return $this->related_field->convert_value($value);
    }
}