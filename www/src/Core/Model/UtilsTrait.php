<?php
/**
 * @company: Bencom (c) 2018.
 * @project: aviasales
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

/**
 * @company: Bencom (c) 2018.
 * @project: aviasales
 * @author : baster
 * @version: 1
 */

namespace Core\Model;

/**
 * Trait UtilsTrait
 *
 * @package Core\Model
 */
trait UtilsTrait
{
    /**
     * @return array
     */
    public function toArray()
    {
        $data = get_object_vars($this);

        $normalise = function (&$item)
        {
            if (is_object($item)) {
                $item = $item->toArray();
            }
        };

        array_walk_recursive($data, $normalise);

        return $data;
    }
}
