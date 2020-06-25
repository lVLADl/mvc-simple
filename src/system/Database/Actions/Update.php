<?php


namespace App\System\Database\Actions;
use App\System\Database\Model;

interface Update {
    public function update(array $update_array);
}