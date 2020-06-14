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

# -- Caching
if(config('general.debug') == true) {
    __stop_caching();
}
# --

# -- Retrieving urls
$URL = [];
require_once BASE_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'urls.php';
# --

# -- Database
    # -- Medoo
    use Medoo\Medoo;

    # Initialize
    $database = new Medoo([
        'database_type' => config('general.database_type'),
        'database_name' => config('general.database_name'),
        'server' => config('general.server'),
        'username' => config('general.username'),
        'password' => config('general.password'),
    ]);
    # --
# --

# -- Twig-template
    # -- Core
    $loader = new \Twig\Loader\FilesystemLoader(
        BASE_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Templates'
    );
    $twig = new \Twig\Environment($loader, [
        'debug' => config('general.debug')
    ]);
    # --

    # -- Loading filters
    require_once BASE_DIR . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'System' . DIRECTORY_SEPARATOR . 'Template' . DIRECTORY_SEPARATOR . 'filters.php';
    # --
# --

use App\System\Application;
$app = new Application();

$app->run();