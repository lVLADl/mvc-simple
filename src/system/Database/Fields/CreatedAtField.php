<?php


namespace App\System\Database\Fields;



use Carbon\Carbon;

class CreatedAtField extends Field {
    public $type = 'date-time';
    public string $field_name = 'created_at';


    public function convert_value()
    {
        return 'CURRENT_TIMESTAMP';
    }

    public function __construct() {
        $options['default'] = 'CURRENT TIMESTAMP';

        parent::__construct($this->field_name, $options);
    }

    public function standard_validators()
    {
        /*
         * Removes standard value by data-type- validation
         * which's not suitable for the advanced data-types.
         * TODO: I should make it more trivial in the future
         * TODO: updates:
         *          - add boolean flag to remove this "not smart enough validator"
         *          - make a function to the base Field class which will remove it and rewrite this in child-classes
         *
         */

        $standard_validators = parent::standard_validators();
        unset($standard_validators['default-datatype-validator']);

        return $standard_validators;
    }

    public function default_validators()
    {
        return [];
    }
}