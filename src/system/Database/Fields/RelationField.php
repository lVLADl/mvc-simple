<?php


namespace App\System\Database\Fields;

use App\System\Database\Model;

abstract class RelationField extends Field {
    public $related_class;
    public Field $related_field;

    public $type;
    public string $max_length;
    public function convert_value($value)
    {
        return $this->related_field->convert_value($value);
    }
}