<?php


namespace App\System\Database\Actions;
use App\System\Database\Query;

interface Create {
    public function create(): Query;
}