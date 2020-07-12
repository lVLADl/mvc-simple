<?php


namespace App\Model;


use App\System\Database\Blueprint;
use App\System\Database\Fields\CreatedAtField;
use App\System\Database\Fields\StringField;
use App\System\Database\Fields\UpdatedAtField;
use App\System\Database\Model;
use Tightenco\Collect\Support\Collection;

class UserModel extends Model {
    public static string $model_name = 'user';

    public static function where(): Collection
    {
        // TODO: Implement where() method.
    }

    # TODO: remove static
    public static function roles_foreign() {
        return static::one_to_many(Role::class, RoleUser::class, 'user_id', 'role_id');
    }

     public static function blueprint(Blueprint $blueprint) {
        $blueprint
            ->add_field(new StringField('name', 155, ['null']))
            ->add_field(new StringField('email', 135, ['primary_key']))
            ->add_field(new StringField('password', 365)) # -- hashed

            ->add_field(new CreatedAtField)
            ->add_field(new UpdatedAtField);


         return $blueprint;
    }

    /*TODO: make Request-class to validate, collect, ... all the necessary (on that lvl, validation will be performed */
    public static function register(array $args): UserModel {
        /* replace with unique-constraint */
        if(static::all()->where('email', $args['email'])->count() == 0) {
            $password = $args['password'];
            $args['password'] = password_hash($password, config('auth.hashing-method'));

            return static::create($args);
        } else {
            return static::get($args['email']);
        }
    }

    public function authorize(string $password) {
        if(password_verify($password, $this->password)) {
            session_add('authorized', true);
            session_add('email', $this->email);

            return true;
        }
        return false;
    }


    public function __toString() {
        return 'User:[' . $this->email .']';
    }
}