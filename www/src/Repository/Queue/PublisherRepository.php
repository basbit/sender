<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Repository\Queue;

use Domain\Queue\Repository\PublisherInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class PublisherRepository implements PublisherInterface
{
    /**
     * @var AMQPChannel
     */
    private $channel;

    /**
     * @var string
     */
    private $exchangeName;

    /**
     * @var array
     */
    protected $message;

    /** @var string */
    protected $routingKey;

    /**
     * QueuePublisher constructor.
     *
     * @param             $exchangeName
     * @param AMQPChannel $channel
     */
    public function __construct($exchangeName, $channel)
    {
        $channel->exchange_declare($exchangeName, 'direct', false, false, false);
        $channel->queue_declare($exchangeName, false, false, false, false);

        $this->channel      = $channel;
        $this->exchangeName = $exchangeName;
    }

    /**
     * @param       $routingKey
     * @param array $arguments
     */
    public function setData($routingKey, array $arguments): void
    {
        $this->routingKey = $routingKey;

        $this->message = json_encode(
            [
                'job'  => $routingKey,
                'args' => $arguments
            ]
        );
    }

    /**
     *
     */
    public function publish(): void
    {
        $amqpmessage = new AMQPMessage($this->message, [
            'content_type'  => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        $this->channel->queue_bind($this->exchangeName, $this->exchangeName, $this->routingKey);
        $this->channel->basic_publish($amqpmessage, $this->exchangeName, $this->routingKey);

        $this->channel->close();
    }
}
