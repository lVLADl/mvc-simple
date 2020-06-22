<?php


namespace App\System\Database\Actions;
use Tightenco\Collect\Support\Collection;

interface All {
    public static function all(): Collection;
}