<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */


$app->any('/consumer', App\Module\Console\Action\Consumer::class)
    ->setName('console');
$app->any('/producer', App\Module\Console\Action\Producer::class)
    ->setName('console');
