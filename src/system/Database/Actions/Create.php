<?php


namespace App\System\Database\Actions;

use App\System\Database\Model;

interface Create {
    public static function create(): Model;
}