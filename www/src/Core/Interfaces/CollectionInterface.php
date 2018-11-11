<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Core\Interfaces;

/**
 * Interface CollectionInterface
 *
 * @package Core\Interfaces
 */
interface CollectionInterface
{
    /**
     * @return mixed
     */
    public function toArray();

    /**
     * @param ModelInterface $model
     * @param null           $key
     *
     * @return mixed
     */
    public function add(ModelInterface $model, $key = null);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function delete($key);
}
