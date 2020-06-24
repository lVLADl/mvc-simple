<?php


namespace App\Model;


use App\System\Database\Blueprint;
use App\System\Database\Fields\BooleanField;
use App\System\Database\Fields\DateField;
use App\System\Database\Fields\IntegerField;
use App\System\Database\Fields\StringField;
use App\System\Database\Model;
use Carbon\Carbon;
use Tightenco\Collect\Support\Collection;

class ExampleModel extends Model {
    public static string $model_name = 'example';

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

     public static function blueprint(Blueprint $blueprint) {
        $blueprint
            /*->add_field(new IntegerField('id', [
            'primary_key',
            'auto_increment',
            ]))*/
            ->add_field(new StringField('message', 155, [
                'primary_key'
             ]))
            ->add_field(new BooleanField('is_published', [
                'default' => true
            ]))
            ->add_field(new DateField('date', ['default' => new Carbon('2020-06-23')]))
            ->add_field(new StringField('my_name', 155));

         return $blueprint;
    }

    public function __toString()
    {
        return __CLASS__;
    }
}