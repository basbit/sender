<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Core\Mapper;

use Core\Interfaces\CollectionInterface;
use Core\Interfaces\MapperInterface;
use Core\Interfaces\ModelInterface;

/**
 * Class CoreMapper
 *
 * @property CollectionInterface collection
 * @property ModelInterface      model
 * @package Core\AbstractMapper
 */
abstract class CoreMapper implements MapperInterface
{
    /**
     * @param array $rows
     *
     * @return mixed
     */
    protected function mapOne(array $rows = [])
    {
        $returnOne = null;

        // Throw the error exception when no article is found.
        if ($rows !== false) {
            $returnOne = $this->mapObject(array_pop($rows));
        }

        return $returnOne;
    }

    /**
     * @param  array $rows
     *
     * @return CollectionInterface
     */
    protected function mapCollection(array $rows = []): CollectionInterface
    {
        $collection = new $this->collection();
        foreach ($rows as $row) {
            $collection->add($this->mapObject($row));
        }

        return $collection;
    }

    /**
     * @param  array $row
     *
     * @return ModelInterface
     */
    protected function mapObject(array $row): ModelInterface
    {
        $model = new $this->model($row);

        return $model;
    }
}
