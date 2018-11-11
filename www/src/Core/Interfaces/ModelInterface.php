<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Core\Interfaces;

/**
 * Interface ModelInterface
 *
 * @package Core\Interfaces
 */
interface ModelInterface
{
    /**
     * @param array $params
     *
     * @return mixed
     */
    public function setOptions(array $params);

    /**
     * @return mixed
     */
    public function toArray();
}

