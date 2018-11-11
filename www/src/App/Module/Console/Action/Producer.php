<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace App\Module\Console\Action;

use Core\Component\AbstractController;
use Domain\Mail\Mapper\MailMapper;
use Domain\Queue\Service\QueueService;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Repository\Queue\PublisherRepository;

/**
 * Class LoginAction
 *
 * @package App\Module\User\Action
 */
class Producer extends AbstractController
{
    /**
     * @param $args
     *
     * @return mixed|void
     * @throws \Exception
     * @throws \Throwable
     */
    public function execute($args)
    {
        $this->container->get('mail');
        /** @var AMQPStreamConnection $Queue */
        $queue = $this->container->get('Queue');

        $publisher = new PublisherRepository('sender', $queue->channel());

        $queueService = new QueueService($queue);
        $queueService->publish($this->request->getQueryParams(), $publisher, new MailMapper());

        $queue->close();
    }
}
