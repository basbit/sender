<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Test\Domain\Queue;

use Domain\Mail\SendMailJob;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Repository\Queue\ConsumerRepository;
use Repository\Queue\PublisherRepository;

/**
 * Class EndToEndTest
 *
 * @package Tests\SlimQ
 */
class EndToEndTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    use MockeryPHPUnitIntegration;

    /** @var string */
    public $exchange = 'sender';

    /** @var array */
    public $arguments = ["to" => "g-serg88@yandex.ru", "message" => "test", "subject" => "test"];

    /** @var string */
    public $queueName = 'SendMailJob';

    /** @var \App\App $app */
    private $app;

    /**
     * EndToEndTest constructor.
     *
     * @param null|string $name
     * @param array       $data
     * @param string      $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        $this->app = $this->runApp();
        parent::__construct($name, $data, $dataName);
    }

    /**
     *
     */
    public function runApp()
    {
        if (!defined("ROOT_PATH")) {
            define("ROOT_PATH", __DIR__ . "/../../../");
        }
        $CONFIG_PATH = ROOT_PATH . "config/";

        // Include Composer autoloader.
        require_once ROOT_PATH . 'vendor/autoload.php';

        // Configure the Slim app.
        $settings = require $CONFIG_PATH . 'env/dev/config.php';

        // Using a different container
        $container = new \SlimAura\Container($settings);

        // Get an instance of Slim.
        $app = new \App\App($container);

        if (in_array(PHP_SAPI, ['cli', 'cli-server'])) {
            $app->add(new \Core\Middleware\CliRequest($container));
            $app->isConsole = true;
        }

        // Register dependencies.
        require $CONFIG_PATH . 'dependencies.php';

        return $app;
    }

    /**
     *
     */
    public function testPublisher()
    {
        $channel = \Mockery::mock(AMQPChannel::class);

        $channel->shouldReceive([
            'exchange_declare' => null,
            'queue_declare'    => null,
            'queue_bind'       => null,
            'basic_publish'    => null,
            'close'            => null
        ]);

        $publisher = new PublisherRepository($this->exchange, $channel);
        $publisher->setData($this->queueName, $this->arguments);

        $publisher->publish();
    }

    /**
     *
     */
    public function testConsumer()
    {
        $channel = \Mockery::mock(AMQPChannel::class);

        $channel->shouldReceive([
            'exchange_declare' => null,
            'queue_declare'    => null,
            'basic_qos'        => null,
            'basic_consume'    => null,
            'wait'             => null,
            'close'            => null,
            'basic_ack'        => null,
        ]);

        $queuemessage = json_encode(
            [
                'job'  => $this->queueName,
                'args' => $this->arguments
            ]
        );

        $message                = \Mockery::mock(AMQPMessage::class);
        $message->body          = $queuemessage;
        $message->delivery_info = ['channel' => $channel, 'delivery_tag' => 'abc'];

        $consumer = \Mockery::mock(ConsumerRepository::class);

        $consumer->shouldReceive('job')
                 ->andReturn();

        $logger = $this->app->getContainer()
                            ->get('Monolog\Logger');

        try {
            /** @var AMQPStreamConnection $Queue */
            $queue    = $this->app->getContainer()
                                  ->get('Queue');
            $consumer = new ConsumerRepository($this->app->getContainer(), $this->exchange, $queue->channel(), $logger);
            $consumer->execute($message);
        } catch (\Exception $e) {

        }

        /** @var SendMailJob $jobClass */
        $this->assertEquals(true, $consumer->isExecuted);
    }

    /**
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function testBadConsumer()
    {
        $channel = \Mockery::mock(AMQPChannel::class);
        $channel->shouldReceive([
            'exchange_declare' => null,
            'queue_declare'    => null,
            'basic_qos'        => null,
            'basic_consume'    => null,
            'wait'             => null,
            'close'            => null,
            'basic_nack'       => null,
        ]);

        $queuemessage = json_encode(
            [
                'job'  => $this->queueName . '1', // broke queue
                'args' => $this->arguments
            ]
        );

        $message                = \Mockery::mock(AMQPMessage::class);
        $message->body          = $queuemessage;
        $message->delivery_info = ['channel' => $channel, 'delivery_tag' => 'abc'];

        $logger = $this->app->getContainer()
                            ->get('Monolog\Logger');

        try {
            /** @var AMQPStreamConnection $Queue */
            $queue    = $this->app->getContainer()
                                  ->get('Queue');
            $consumer = new ConsumerRepository($this->app->getContainer(), $this->exchange, $queue->channel(), $logger);
            $consumer->execute($message);
        } catch (\Exception $e) {

        }
        /** @var SendMailJob $jobClass */
        $this->assertEquals(false, $consumer->isExecuted);
    }

}