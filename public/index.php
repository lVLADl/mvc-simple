<?php

# -- Autoload
require_once __DIR__.'/../vendor/autoload.php';
# --
define('BASE_DIR', __DIR__ . DIRECTORY_SEPARATOR . '..');

# -- Helpers
require_once BASE_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'helper_functions.php';
# --


use App\System\Application;
# $_SERVER['REQUEST_URI'];
$app = new Application();
echo "\n";
var_export(config('general.TTT'));
?>
