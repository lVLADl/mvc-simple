<?php


namespace App\System\Database\Actions;

use App\System\Database\Model;

interface Delete {
    public static function delete(): Model;
}