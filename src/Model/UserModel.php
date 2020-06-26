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

class UserModel extends Model {
    public static string $model_name = 'user';

    public static function where(): Collection
    {
        // TODO: Implement where() method.
    }

     public static function blueprint(Blueprint $blueprint) {
        $blueprint
            ->add_field(new StringField('name', 155, ['null']))
            ->add_field(new StringField('email', 135))
            ->add_field(new StringField('password', 365))

            ->add_field(new CreatedAtField)
            ->add_field(new UpdatedAtField);


         return $blueprint;
    }
}