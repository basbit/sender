<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

try {
    $container->set('SendMailJob', function () use ($container)
    {
        $log = $container->get('Monolog\Logger');

        return new \Domain\Mail\SendMailJob($container, $log);
    });
} catch (\Aura\Di\Exception\ContainerLocked $e) {
    throw $e;
} catch (\Aura\Di\Exception\ServiceNotObject $e) {
    throw $e;
} catch (\Psr\Container\NotFoundExceptionInterface $e) {
    throw $e;
} catch (\Psr\Container\ContainerExceptionInterface $e) {
    throw $e;
}
