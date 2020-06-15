<?php


namespace App\System\Database\Actions;
use App\System\Database\Query;

interface All {
    public function all(): Query;
}