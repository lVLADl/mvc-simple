<?php


namespace App\System\Database\Fields;


class IntegerField extends Field {
    public $type = 'integer';

    public function __toString()
    {
        return parent::__toString() . ' ' . self::datatype_database[$this->type];
    }

    public function system_convert_to_sql(): array {
        $fn = $this->field_name;

        $out[$fn][] = $this->get_mysql_type_equivalent();
        foreach($this->getProperties() as $value) {
            if($value) { # TODO: Fix that: unknown property is trying to get created despite the fact
                         #  TODO: it's not transfered from the getProperties()- method
                $out[$fn][] = $value;
            }
        }

        return $out;
    }
}