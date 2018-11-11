<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

try {
    $container->set('callableResolver', new Core\Component\CallableResolver($container));
} catch (\Aura\Di\Exception\ContainerLocked $e) {
    throw $e;
} catch (\Aura\Di\Exception\ServiceNotObject $e) {
    throw $e;
}
