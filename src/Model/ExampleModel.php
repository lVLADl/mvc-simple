<?php


namespace App\Model;


use App\System\Database\Blueprint;
use App\System\Database\Fields\BooleanField;
use App\System\Database\Fields\IntegerField;
use App\System\Database\Fields\StringField;
use App\System\Database\Model;
use Tightenco\Collect\Support\Collection;

class ExampleModel extends Model {
    public static function all(): Collection
    {
        // TODO: Implement all() method.
    }

    public static function create(): Model
    {
        // TODO: Implement create() method.
    }

    public static function update(): Model
    {
        // TODO: Implement update() method.
    }

    public static function delete(): Model
    {
        // TODO: Implement delete() method.
    }

    public static function where(): Collection
    {
        // TODO: Implement where() method.
    }

    public static function get(): Model
    {
        // TODO: Implement get() method.
    }

     public static function blueprint(Blueprint $blueprint) {
        $blueprint
            ->add_field(new IntegerField('integer_sample', [
            'primary_key',
            'auto_increment',
            ]))
            ->add_field(new StringField('message', 155, [
                'null',
                'default' => 'default string value'
             ]))
            ->add_field(new BooleanField('is_published', [
                'default' => true
            ]))
            ->add_field(new StringField('weather', 100, [/*TODO*/]));

         return $blueprint;
    }
}