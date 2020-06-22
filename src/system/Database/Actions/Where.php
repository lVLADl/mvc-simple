<?php


namespace App\System\Database\Actions;
use Tightenco\Collect\Support\Collection;

interface Where {
    public static function where(): Collection;
}