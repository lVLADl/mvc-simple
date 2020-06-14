<?php


namespace App\Model\Actions;


use App\Model\Query;

interface Where {
    public function where(): Query;
}