<?php


namespace App\System\Database\Fields;


class BooleanField extends Field {
    public $type = 'boolean';
    public function convert_value($value) {
        return ($value?'TRUE':'FALSE');
    }
}