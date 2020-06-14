<?php


namespace App\Model\Actions;


use App\Model\Query;

interface Create {
    public function create(): Query;
}