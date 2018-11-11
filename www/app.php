<?php
/**
 * @company: sender (c) 2018.
 * @project: sender.ru
 * @module : framework
 * @author : baster
 * @version: 1
 */

// Turn on debug.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define("ENVIRONMENT", "dev");

if (!defined("ROOT_PATH")) {
    define("ROOT_PATH", __DIR__ . "/");
}

define("CONFIG_PATH", ROOT_PATH . "config/");

// Include Composer autoloader.
require_once ROOT_PATH . 'vendor/autoload.php';

// Start the session.
session_cache_limiter(false);
session_start();

// Configure the Slim app.
$settings = require CONFIG_PATH . 'env/' . ENVIRONMENT . '/config.php';

// Using a different container
$container = new SlimAura\Container($settings);

// Get an instance of Slim.
$app = new \App\App($container);

if (in_array(PHP_SAPI, ['cli', 'cli-server'])) {
    $app->add(new \Core\Middleware\CliRequest($container));
    $app->isConsole = true;
}

// Register dependencies.
require CONFIG_PATH . 'dependencies.php';

// Register routes.
require CONFIG_PATH . 'routes.php';

// Run the application!
try {
    $app->run();
} catch (\Slim\Exception\MethodNotAllowedException $e) {
    $app->errorHandler($e);
} catch (\Slim\Exception\NotFoundException $e) {
    $app->errorHandler($e);
} catch (Exception $e) {
    $app->errorHandler($e);
}
