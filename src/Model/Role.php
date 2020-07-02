<?php


namespace App\Model;


use App\System\Database\Blueprint;
use App\System\Database\Fields\CreatedAtField;
use App\System\Database\Fields\IntegerField;
use App\System\Database\Fields\StringField;
use App\System\Database\Fields\UpdatedAtField;
use App\System\Database\Model;
use Tightenco\Collect\Support\Collection;

class Role extends Model {
    public static string $model_name = 'example';

    public static function where(): Collection
    {
        // TODO: Implement where() method.
    }

     public static function blueprint(Blueprint $blueprint) {
        $blueprint
            ->add_field(new StringField('role_name', 255))
            ->add_field(new IntegerField('id', ['primary_key', 'auto_increment']))

            ->add_field(new CreatedAtField)
            ->add_field(new UpdatedAtField);

         return $blueprint;
    }

    public function __toString() {
        $id = $this->id;
        $role = $this->role_name;
        return "[$id] $role";
    }
}