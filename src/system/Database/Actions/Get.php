<?php


namespace App\System\Database\Actions;

use App\System\Database\Model;

interface Get {
    public static function get($id): Model;
}