<?php


namespace App\Model;


use App\System\Database\Blueprint;
use App\System\Database\Fields\CreatedAtField;
use App\System\Database\Fields\IntegerField;
use App\System\Database\Fields\OneToManyRelationField;
use App\System\Database\Fields\UpdatedAtField;
use App\System\Database\Model;
use Tightenco\Collect\Support\Collection;

class RoleUser extends Model {
    public static string $model_name = 'example';

    public static function where(): Collection
    {
        // TODO: Implement where() method.
    }

     public static function blueprint(Blueprint $blueprint) {
        $blueprint
            ->add_field(new IntegerField('id', ['primary_key', 'auto_increment']))

            ->add_field(new OneToManyRelationField('user_id', 'user', 'email'))
            ->add_field(new OneToManyRelationField('role_id', 'role', 'id'))

            ->add_field(new CreatedAtField)
            ->add_field(new UpdatedAtField);

         return $blueprint;
    }

    public function __toString(): string {
        $id = $this->id;

        $role = $this->role_id;
        $user = $this->user_id;

        return "[$id] $role, $user";
    }
}