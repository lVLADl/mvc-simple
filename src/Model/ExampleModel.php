<?php


namespace App\Model;


use App\System\Database\Blueprint;
use App\System\Database\Fields\BooleanField;
use App\System\Database\Fields\CreatedAtField;
use App\System\Database\Fields\DateField;
use App\System\Database\Fields\DateTimeField;
use App\System\Database\Fields\IntegerField;
use App\System\Database\Fields\StringField;
use App\System\Database\Fields\UpdatedAtField;
use App\System\Database\Model;
use Carbon\Carbon;
use Tightenco\Collect\Support\Collection;

class ExampleModel extends Model {
    public static string $model_name = 'example';

    public static function where(): Collection
    {
        // TODO: Implement where() method.
    }

     public static function blueprint(Blueprint $blueprint) {
        $blueprint
            ->add_field(new IntegerField('id', [
                'primary_key',
                'auto_increment'
            ]))
            ->add_field(new StringField('message', 155, [
                'default' => uniqid()
             ]))
            ->add_field(new BooleanField('is_published', [
                'default' => true
            ]))
            ->add_field(new DateField('date', ['default' => new Carbon('2020-06-23')]))
            ->add_field(new StringField('my_name', 155, ['null']))
            ->add_field(new DateTimeField('datetime', [
                'default' => new Carbon('2020-06-17 23:09:29')
            ]))

            ->add_field(new CreatedAtField)
            ->add_field(new UpdatedAtField);

         return $blueprint;
    }

    public function __toString()
    {
        return "[$this->id]: $this->message";
    }
}