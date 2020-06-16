<?php


namespace App\System\Database\Fields;


abstract class Field {
    public string $field_name;
    protected array $options;

    protected $type;
    protected function check_data_type($value): bool {
        return gettype($value) == $this->type;
    }
    protected function convert_default_value($value) {
        return $value;
    }
    protected const datatype_database = [
        'integer' => 'INT',
        'text' => 'TEXT',
        'boolean' => 'BOOL',
        'string' => 'VARCHAR(', # if starts with '('-sign, then it's required to be expanded
        'char' => 'CHAR(1)'
    ];

    public function __construct($field_name, array $options = null) {
        $this->options = [
            'primary_key' => function() {
                return 'PRIMARY KEY';
            },
            'default' => function($value) {
                if($this->check_data_type($value)) {
                    $out = 'DEFAULT ';
                    return $out . $this->convert_default_value($value);
                } else {
                    throw new \TypeError(__CLASS__ . ' doesn\'t support ' . gettype($value) . '-type, only ' . $this->type);
                }
            },
            'null' => function($value) {
                return ($value)?'NULL':'NOT NULL';
            },
            'unique' => function($value) {
                return 'UNIQUE';
            }
            # expand option-list here ...
        ];
        $this->field_name = $field_name;
        if($options) {
            foreach($this->options as $key => $func) {
                if(isset($options[$key])) {
                    $this->$key = $func($options[$key]);
                }
            }
        }
    }

    public function getProperties() {
        $add = [];
        foreach($this->options as $option=>$func) {
            $add[] = $this->$option;
        }

        return $add;
    }


    #  => get MySQL- equivalent
    public function system_convert_to_sql(): array {
        $fn = $this->field_name;


         $type = $this->get_mysql_type_equivalent();
        if(str_ends_with($type, '(')) {
            $type .= $this->max_length . ')';
        }

        $out[$fn][] = $type;
        foreach($this->getProperties() as $value) {
            if($value) {
                $out[$fn][] = $value;
            }
        }

        return $out;
    }
    public function get_mysql_type_equivalent(): string {
        return self::datatype_database[$this->type];
    }


    public function __toString() {
        return $this->field_name;
    }
    public function __get($name) { }
}