<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Domain\Queue\Service;

use Core\Interfaces\MapperInterface;
use Domain\Queue\Repository\ConsumerInterface;
use Domain\Queue\Repository\PublisherInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Status Service
 *
 * @package Domain\Service
 */
class QueueService
{
    /**
     * @var ConsumerInterface
     */
    protected $consumer;

    /**
     * @var PublisherInterface
     */
    protected $publihser;

    /** @var AMQPStreamConnection */
    protected $queue;

    /**
     * QueueService constructor.
     *
     * @param AMQPStreamConnection $queue
     */
    public function __construct(AMQPStreamConnection $queue)
    {
        $this->queue = $queue;
    }

    /**
     * @param ConsumerInterface $consumer
     *
     * @return ConsumerInterface
     */
    public function setConsumerJob(ConsumerInterface $consumer): ConsumerInterface
    {
        $this->consumer = $consumer;

        return $consumer;
    }

    /**
     * @param PublisherInterface $publihser
     * @param                    $jobName
     * @param array              $data
     *
     * @return PublisherInterface
     */
    public function setPublihserData(PublisherInterface $publihser, $jobName, array $data): PublisherInterface
    {
        $this->publihser = $publihser;
        $this->publihser->setData($jobName, $data);

        return $publihser;
    }

    /**
     * @throws \ErrorException
     */
    public function consume(): void
    {
        $this->consumer->consume();
    }

    /**
     * @param                    $params
     * @param PublisherInterface $publisher
     * @param MapperInterface    $mailMapper
     */
    public function publish($params, PublisherInterface $publisher, MapperInterface $mailMapper)
    {
        $defaultArgs = ["to" => "test@test.ru", "message" => "test", "subject" => "test"];
        foreach ($defaultArgs as $key => $arg) {
            if (!isset($params[$key])) {
                $params[$key] = $arg;
            }
        }

        $mail = $mailMapper->getFilledModel($params)
                           ->toArray();

        $this->setPublihserData($publisher, 'SendMailJob', $mail)
             ->publish();
    }
}
