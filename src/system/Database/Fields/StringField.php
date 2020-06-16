<?php


namespace App\System\Database\Fields;



class StringField extends Field {
    public $type = 'string';
    protected string $max_length;
    public function __construct(string $field_name, int $max_length, array $options = null) {
        parent::__construct($field_name, $options);
        $this->max_length = $max_length;
    }
    protected function convert_default_value($value)
    {
        return "'$value'";
    }
}