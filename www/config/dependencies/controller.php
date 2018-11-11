<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

$container->params[Core\Component\AbstractController::class] = [
    'container' => $container,
    'logger'    => $container->lazyGet('Monolog\Logger')
];

$container->params[Core\Component\CliRequest::class] = [
    'container' => $container,
    'logger'    => $container->lazyGet('Monolog\Logger')
];