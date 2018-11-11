<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Domain\Mail\Mapper;

use Domain\Mail\Model\MailModel;

/**
 * Class GetMapper
 *
 * @package Domian\Data\Mapper
 */
class MailMapper extends AbstractMapper
{
    /**
     * MailMapper constructor.
     *
     */
    public function __construct()
    {

    }

    /**
     * @param $args
     *
     * @return MailModel
     */
    public function getFilledModel($args)
    {
        /** @var MailModel $model */
        $model = $this->mapObject($args);

        return $model;
    }
}
