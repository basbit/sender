<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace App\Module\Console\Action;

use Core\Component\AbstractController;
use Domain\Queue\Service\QueueService;
use Repository\Queue\ConsumerRepository;

/**
 * Class LoginAction
 *
 * @package App\Module\User\Action
 */
class Consumer extends AbstractController
{
    /**
     * @param $args
     *
     * @return mixed|void
     * @throws \ErrorException
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function execute($args)
    {
        /** @var AMQPStreamConnection $Queue */
        $queue = $this->container->get('Queue');
        $logger = $this->container->get('Monolog\Logger');

        $consumer = new ConsumerRepository($this->container, 'sender', $queue->channel(), $logger);

        $queueService = new QueueService($queue);

        $queueService->setConsumerJob($consumer)->consume();

        $queue->close();
    }
}
