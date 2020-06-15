<?php


namespace App\System\Database;

use App\System\Database\Query;
use App\System\Database\Actions\All;
use App\System\Database\Actions\Create;
use App\System\Database\Actions\Delete;
use App\System\Database\Actions\Update;
use App\System\Database\Actions\Where;
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