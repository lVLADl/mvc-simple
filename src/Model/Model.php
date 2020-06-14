<?php


namespace App\Model;


use App\Model\Actions\All;
use App\Model\Actions\Create;
use App\Model\Actions\Delete;
use App\Model\Actions\Update;
use App\Model\Actions\Where;
use Medoo\Medoo;

abstract class Model implements All, Create, Delete, Update, Where {
    private Medoo $db; # -- connection
    public string $model_name;


    public function __construct($model_name) {
        global $database;
        $this->db = &$database;

        $this->model_name = $model_name;
    }
}