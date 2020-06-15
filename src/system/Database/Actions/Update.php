<?php


namespace App\System\Database\Actions;
use App\System\Database\Query;

interface Update {
    public function update(): Query;
}