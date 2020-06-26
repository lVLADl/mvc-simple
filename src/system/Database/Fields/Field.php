<?php


namespace App\System\Database\Fields;


/*
 * Used for:
 *  1. Declaration purpose: ORM
 *  2. Models-instances use them as instances of values (instead of values itself: has default/custom validators, ...)
 *
 */

abstract class Field {
    public array $validators = [];
    public string $field_name;
    protected array $options;

    public function validate($value) {
        foreach($this->validators as $validator) {
            $validator($value);
        }
    }

    protected $type;
    protected const datatype_database = [
        'integer' => 'INT',
        'text' => 'TEXT',
        'boolean' => 'BOOLEAN',
        'string' => 'VARCHAR(', # if starts with '('-sign, then it's required to be expanded
        'char' => 'CHAR(1)', # TODO
        'date' => 'DATE',
        'date-time' => 'TIMESTAMP'
    ]; # TODO: delegate it to the children-fields

    # Manages in what way, value will be transformed for SQL- queries
    # <REWRITABLE>
    public function convert_value($value) {
        return $value;
    }

    # TODO: Implement UNIQUE, INDEX- constraints
    # By the properties, it's meant constraints and others (default, [index], primary, unique, ...)
    # The function goes throughout the all, which are set for the instance
    public function getProperties() {
        $add = [];
        foreach($this->options as $option=>$func) {
            $add[] = $this->$option;
        }

        return $add;
    }

    # Constructor could be called only in some special cases, such as
    # implementing new properties, ... .
    # Nevertheless, parent constructor should be called
    public function __construct($field_name, array $options = []) {
        if(array_key_exists('validators', $options)){
            foreach($options['validators'] as $validator) {
                $this->validators[] = $validator;
            } # -- attach custom validators
        }
        $this->validators = array_merge($this->validators, $this->standard_validators(), $this->default_validators());
        # -- adds standard(for field-type), expanded validators: by the default, null is set

        # CONSTRAINTS
        $this->options = [
            'primary_key' => function() {
                return 'PRIMARY KEY';
            },
            'default' => function($value) {
                $this->validate($value);
                return 'DEFAULT (' . $this->convert_value($value) . ')';
            },
            'null' => function() {
                return 'NULL';
            },
            'unique' => function() {
                return 'UNIQUE';
            },
            'auto_increment' => function() {
                return 'AUTO_INCREMENT';
            }
            # expand option-list here ...
        ];
        $this->field_name = $field_name;
        if($options) {
            foreach($this->options as $key => $func) {
                if(in_array($key, $options, true) and $key!='default') {
                    $this->$key = $func($options[$key]??null);
                }
                if(isset($options['default'])) {
                    $this->default = $this->options['default']($options['default']);
                }
            }
        } # set constraints
    }
    public function get_constraints() {
        $out = [];
        foreach($this->options as $key => $func) {
            if($this->$key) {
                $out[] = $this->$key;
            }
        }
        return $out;
    }

    # Acceptable for all the data-types
    protected function standard_validators() { /*TODO-1: */
        return [
            'default-datatype-validator' => function($value) {
                /*
                 * Validates data-type
                 */
                if(!(gettype($value) == $this->type)) {
                    throw new \TypeError(__CLASS__ . ' doesn\'t support ' . gettype($value) . '-type, only ' . $this->type);
                }
            }
        ];
    }

    # Validators for the specific field-types
    public function default_validators() {
        return [
            /*
            Each function should accept one argument - value.
            Function doesn't return anything. If value is wrong, exception gets invoked
            function($value) {
                # ...
            },
            */
        ];
    }

    # Reflects field's appearance in the array which's used by MeDoo composer package
    # To create new table.
    public function system_convert_to_sql(): array {
        $fn = $this->field_name;


        $type = $this->get_mysql_type_equivalent();
        # If data-type requires some additional arguments,
        # $type variable ends with open-bracket: it means, it's required
        # to be extended with the argument: length
        if(str_ends_with($type, '(')) {
            $type .= $this->max_length . ')';
        }

        $out[$fn][] = $type;
        foreach($this->get_constraints() as $value) {
            if($value) {
                $out[$fn][] = $value;
            }
        }

        return $out;
    }
    public function get_mysql_type_equivalent(): string {
        return self::datatype_database[$this->type];
    }


    # <REWRITABLE>
    public function __toString() {
        return $this->field_name . ' ' . self::datatype_database[$this->type] . ' ' . join(', ', $this->get_constraints());
    }

    public function __get($name) {
        return null;
    }
}