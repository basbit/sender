<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Repository\Queue;

use Domain\Queue\Repository\ConsumerInterface;
use Monolog\Logger;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Container\ContainerInterface;

class ConsumerRepository implements ConsumerInterface
{
    /** timeout */
    const TIMEOUT = 30;

    /** @var AMQPChannel */
    private $channel;

    /** @var ContainerInterface */
    private $container;

    /** @var \Ramsey\Uuid\UuidInterface */
    private $hash;

    /** @var string */
    private $queueName;

    /** @var \Monolog\Logger $log */
    protected $log;

    /** @var bool */
    public $isExecuted = null;

    /**
     * QueueConsumer constructor.
     *
     * @param ContainerInterface $container
     * @param                    $queueName
     * @param AMQPChannel        $channel
     *
     * @param Logger             $looger
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container, $queueName, $channel, Logger $looger = null)
    {
        $channel->exchange_declare($queueName, 'direct', false, false, false);
        $channel->queue_declare($queueName, false, false, false, false);

        $this->container = $container;
        $this->channel   = $channel;
        $this->hash      = time();
        $this->queueName = $queueName;
        $this->log       = $looger;
    }

    /**
     * @throws \ErrorException
     */
    public function consume(): void
    {
        $this->channel->basic_qos(null, 1, null);

        $this->channel->basic_consume($this->queueName, $this->hash, false, false, false, false, [$this, 'execute']);

        while ($this->isExecuted == null) {
            $this->log->addInfo('Waiting for incoming messages');
            $this->channel->wait(null, false, self::TIMEOUT);
        }

        $this->channel->close();
    }

    /**
     * @param AMQPMessage $message
     *
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function execute($message): void
    {
        if (empty($message->body)) {
            $this->isExecuted = false;

            return;
        }

        $job = json_decode($message->body, true);

        if (empty($job)) {
            $this->isExecuted = false;

            return;
        }

        try {
            $jobClass = $this->container->get($job['job']);

            $result = $jobClass->job($job['args']);
        } catch (\Exception $ex) {
            $this->isExecuted = false;
            $this->log->addError($ex->getMessage());
            $result = false;
        }

        /** @var AMQPChannel $channel */
        $channel = $message->delivery_info['channel'];

        if ($result) {
            $channel->basic_ack($message->delivery_info['delivery_tag']);

            $this->isExecuted = true;

            return;
        } else {
            if (!empty($jobClass)) {
                $this->log->addError(json_encode($jobClass->errorInfo));
            }
        }

        $this->isExecuted = false;
        $channel->basic_nack($message->delivery_info['delivery_tag']);

        return;
    }
}
