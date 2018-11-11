<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Domain\Queue\Repository;

use Monolog\Logger;
use Psr\Container\ContainerInterface;

/**
 * Interface JobInterface
 *
 * @package Domain\Queue
 */
interface ConsumerInterface
{
    /**
     * ConsumerInterface constructor.
     *
     * @param ContainerInterface $container
     * @param                    $queueName
     * @param                    $channel
     * @param Logger|null        $looger
     */
    public function __construct(ContainerInterface $container, $queueName, $channel, Logger $looger = null);

    /**
     * @throws \ErrorException
     */
    public function consume(): void;

    /**
     * @param $message
     *
     * @return void
     */
    public function execute($message): void;
}