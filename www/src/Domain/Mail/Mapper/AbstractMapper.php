<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Domain\Mail\Mapper;

use Core\Mapper\CoreMapper;

/**
 * Class AbstractMapper
 *
 * @package Domain\Data\Mapper
 */
abstract class AbstractMapper extends CoreMapper
{
    /**
     * @var UserRepositoryInterface
     */
    protected $repository;

    /**
     * @var string
     */
    protected $model = 'Domain\Mail\Model\MailModel';

    /**
     * @var string
     */
    protected $collection = 'Domain\Mail\Model\MailCollection';
}
