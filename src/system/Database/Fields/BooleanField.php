<?php


namespace App\System\Database\Fields;


class BooleanField extends Field {
    public $type = 'boolean';
    protected function convert_default_value($value) {
        return ($value?'TRUE':'FALSE');
    }
}