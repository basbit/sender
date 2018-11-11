<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Core\Interfaces;

use Monolog\Logger;
use Psr\Container\ContainerInterface;

/**
 * Interface JobInterface
 */
interface JobInterface
{
    /**
     * JobInterface constructor.
     *
     * @param ContainerInterface $container
     * @param Logger             $log
     */
    public function __construct(ContainerInterface $container, Logger $log);

    /**
     * @param array $args
     *
     * @return mixed
     */
    public function job(array $args);
}