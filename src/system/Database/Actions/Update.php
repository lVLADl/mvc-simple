<?php


namespace App\System\Database\Actions;
use App\System\Database\Model;

interface Update {
    public static function update(): Model;
}