<?php


namespace App\System\Database\Fields;


abstract class Field {
    public string $field_name;
    protected array $options;

    protected $type;
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
                return "DEFAULT " . $value;
            },
            'null' => function($value) {
                return ($value)?'NULL':'NOT NULL';
            },
            /*'max_length' => function($value) { TODO

            }*/
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
    public abstract function system_convert_to_sql(): array;
    public function get_mysql_type_equivalent(): string {
        return self::datatype_database[$this->type];
    }


    public function __toString() {
        return $this->field_name;
    }
    public function __get($name) { }
}