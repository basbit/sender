<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Domain\Queue\Repository;

/**
 * Interface JobInterface
 *
 * @package Domain\Queue
 */
interface PublisherInterface
{
    /**
     * ConsumerInterface constructor.
     *
     * @param             $exchangeName
     * @param             $channel
     */
    public function __construct($exchangeName, $channel);

    /**
     * @param       $routingKey
     * @param array $arguments
     */
    public function setData($routingKey, array $arguments): void;

    /**
     *
     */
    public function publish(): void;
}