<?php


namespace App\System\Database\Fields;


class IntegerField extends Field {
    public $type = 'integer';

    public function __toString()
    {
        return parent::__toString() . ' ' . self::datatype_database[$this->type];
    }
}