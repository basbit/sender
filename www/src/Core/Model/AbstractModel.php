<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Core\Model;

use Core\Interfaces\ModelInterface;

abstract class AbstractModel implements ModelInterface
{
    /**
     * Import the utils.
     */
    use UtilsTrait;

    /**
     * Force Extending class to define this method.
     * `am array $params [description]
     *
     * @param array $params
     *
     * @return void
     */
    abstract public function setOptions(array $params): void;
}
