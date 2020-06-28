<?php


namespace App\System;


class Request {
    public function __construct() {
        $this->validation_rules = array_merge($this->core_validation_rules(), $this->additional_validation_rules());

    }
    public function get(string $key=null, $default=null) {
        if($key) {
            return @$_GET[$key] ?? $default;
        } else {
            return $_GET;
        }
    }
    public function post(string $key=null, $default=null) {
        if($key) {
            return @$_POST[$key] ?? $default;
        } else {
            return $_POST;
        }
    }

    # -- Validation
    private array $validation_rules;

    protected function core_validation_rules(): array {
        return [
            'required' => function($value){
                if(!$value) {

                }
            },
        ];
    }

    protected function additional_validation_rules(): array {
        return [];
    }

    /*<REWRITABLE>: this is where the rules get set (as array)*/
    public function validator() {}
    /*System-method that uses validator()-function to verify the post-parameters*/
    public function validate() {}

    # --

    public function __toString() {
        return __CLASS__;
    }
}