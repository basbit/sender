<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Core\Interfaces;

/**
 * Interface ControllerInterface
 *
 * @package Core\Interfaces
 */
interface ControllerInterface
{
    /**
     *
     * @param $args
     *
     * @return mixed
     */
    public function execute($args);

}
