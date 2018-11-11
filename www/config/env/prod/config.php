<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

return [

    'mode'  => 'production',
    'debug' => false,

    'cookies.encrypt'  => true,
    'cookies.lifetime' => '1 year',
    'cookies.path'     => '/',
    'cookies.domain'   => 'sender.ru',

    'settings' => [

        'projectName' => 'sender',

        'displayErrorDetails'    => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        'timezone' => "Europe/Moscow",

        // Monolog settings
        'logger'   => [
            'name'  => 'slim-app',
            'path'  => isset($_ENV['docker']) ? 'php://stdout' : ROOT_PATH . 'logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

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