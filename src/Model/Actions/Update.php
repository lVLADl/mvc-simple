<?php


namespace App\Model\Actions;


use App\Model\Query;

interface Update {
    public function update(): Query;
}