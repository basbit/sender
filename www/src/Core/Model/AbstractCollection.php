<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Core\Model;

use Core\Interfaces\CollectionInterface;
use Core\Interfaces\ModelInterface;

/**
 * Class AbstractCollection
 *
 * @package Core\Model
 */
abstract class AbstractCollection implements CollectionInterface
{
    /**
     * Import the utils.
     */
    use UtilsTrait {
        toArray as protected traitToArray;
    }

    /**
     * Array that store models.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Add a model.
     *
     * @param ModelInterface $model
     * @param [type]         $key
     *
     * @return AbstractCollection
     * @throws \Exception
     */
    public function add(ModelInterface $model, $key = null): AbstractCollection
    {
        // If no key set.
        if ($key === null) {
            $this->items[] = $model;

            return $this;
        }

        // Throw if key already exists.
        if (isset($this->items[$key])) {
            throw new \Exception('Key ' . $key . ' already in use', 500);
        }

        $this->items[$key] = $model;

        return $this;
    }

    /**
     * Delete a model by key.
     *
     * @param  [type] $key
     *
     * @throws \Exception
     */
    public function delete($key)
    {
        // Throw if no key.
        if (!$key) {
            throw new \Exception('$key is not provided', 500);
        }

        // Throw if no match.
        if (!isset($this->items[$key])) {
            throw new \Exception('Invalid key ' . $key, 500);
        }
        unset($this->items[$key]);
    }

    /**
     * Get a model by key.
     *
     * @param $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function get($key)
    {
        // Throw if no key.
        if (!$key) {
            throw new \Exception('$key is not provided', 500);
        }

        // Throw if no match.
        if (!isset($this->items[$key])) {
            throw new \Exception('Invalid key ' . $key, 500);
        }

        return $this->items[$key];
    }

    /**
     * Common method - convert object to array recursively.
     */
    public function toArray()
    {
        $data = $this->traitToArray();

        return $data['items'];
    }
}