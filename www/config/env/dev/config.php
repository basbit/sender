<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

return [

    'mode'  => 'development',
    'debug' => true,

    'cookies.encrypt'  => true,
    'cookies.lifetime' => '1 year',
    'cookies.path'     => '/',
    'cookies.domain'   => 'sender.ru',

    'displayErrorDetails'               => true, // set to false in production
    'addContentLengthHeader'            => false, // Allow the web server to send the content-length header
    'determineRouteBeforeAppMiddleware' => true,

    // Monolog settings
    'logger'                            => [
        'name'  => 'sender',
        'path'  => isset($_ENV['docker']) ? 'php://stdout' : ROOT_PATH . 'logs/app.log',
        'level' => \Monolog\Logger::DEBUG,
    ],

    'settings' => [
        'projectName' => 'sender',
        'timezone'    => 'Europe/Moscow',
    ],

    'mail' => [
        'host'      => 'smtp.yandex.ru',
        'port'      => '465',
        'username'  => '',
        'password'  => '',
        'encryption' => 'ssl',
        'from.name' => '',
        'from'      => '',
    ],

    'queue' => [
        'host'     => '127.0.0.1',
        'port'     => '5672',
        'username' => 'guest',
        'password' => 'guest',
        'path'     => '/'
    ],

];