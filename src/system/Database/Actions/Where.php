<?php


namespace App\System\Database\Actions;
use App\System\Database\Query;

interface Where {
    public function where(): Query;
}