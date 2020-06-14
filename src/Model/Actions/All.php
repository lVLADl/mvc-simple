<?php


namespace App\Model\Actions;


use App\Model\Query;

interface All {
    public function all(): Query;
}