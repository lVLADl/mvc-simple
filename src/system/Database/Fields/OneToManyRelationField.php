<?php


namespace App\System\Database\Fields;



use App\System\Database\Blueprint;
use App\System\Exceptions\RelatedFieldNotFound;

class OneToManyRelationField extends RelationField {
    public function __construct(string $field_name, string $class_name, string $foreign_key_field_name, array $options = []) {
        $related_class = config("models.models")[$class_name];
        $related_class_blueprint = ($related_class)::blueprint(new Blueprint);
        $this->related_field = $related_class_field = $related_class_blueprint->get($foreign_key_field_name);

        if($related_class_field) {
            $this->type = $related_class_field->type;
            if ($this->type == 'string') {
                $this->max_length = $related_class_field->max_length;
            }

            parent::__construct($field_name, $options);
        } else {
            throw new RelatedFieldNotFound('Related field is not found');
        }
    }
}