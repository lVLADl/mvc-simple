<?php

# -- Autoload
require_once __DIR__.'/../vendor/autoload.php';
# --

# -- Constants
define('BASE_DIR', __DIR__ . DIRECTORY_SEPARATOR . '..');
# --

# -- Helpers
require_once BASE_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'helper_functions.php';
# --

# -- Retrieving urls
$URL = [];
require_once BASE_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'urls.php';
# --


use App\System\Application;
$app = new Application();

$app->run();