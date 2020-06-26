<?php

# -- Autoload
require_once __DIR__.'/../vendor/autoload.php';
# --

# -- Constants
define('BASE_DIR', __DIR__ . DIRECTORY_SEPARATOR . '..');
# --

# -- .env -- $_ENV['SECRET_KEY']
$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR . DIRECTORY_SEPARATOR);
$dotenv->load();
# --

# -- Error's displaying
error_reporting(E_ALL ^ E_WARNING); # Remove warnings but leave the rest of the errors
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

# -- Auth
    # $config = new \PHPAuth\Config($database->pdo);
    # $auth = new \PHPAuth\Auth($database->pdo, $config);
# --

# -- Console-commands
if (php_sapi_name() == "cli") {
    $console = new \Symfony\Component\Console\Application();

    $commands = config('command.commands');
    foreach($commands as $command) {
        $console->add($command);
    }
    # ... register commands here
    $console->run();
}
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