<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

try {
    $container->set('Monolog\Logger', function () use ($container)
    {
        $settings = $container->get('settings')['logger'];
        $logger   = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

        return $logger;
    });

    $container->set('mail', function () use ($container)
    {
        $mailer = new \PHPMailer;

        $settings = $container->get('settings');

        $mailer->isSMTP();
        $mailer->Host       = $settings['mail']['host'];
        $mailer->Port       = $settings['mail']['port'];
        $mailer->Username   = $settings['mail']['username'];
        $mailer->Password   = $settings['mail']['password'];
        $mailer->SMTPAuth   = true;
        $mailer->SMTPSecure = $settings['mail']['encryption'];
        $mailer->FromName   = $settings['mail']['from.name'];
        $mailer->From       = $settings['mail']['username'];

        $mailer->isHTML(true);

        return new \Core\Mail\Mailer($mailer, $container);
    });

    $container->set('Queue', function () use ($container)
    {
        $settings = $container->get('settings');

        $stream = new \PhpAmqpLib\Connection\AMQPStreamConnection(
            $settings['queue']['host'],
            $settings['queue']['port'],
            $settings['queue']['username'],
            $settings['queue']['password'],
            $settings['queue']['path']
        );

        return $stream;
    });

} catch (\Aura\Di\Exception\ContainerLocked $e) {
    throw $e;
} catch (\Aura\Di\Exception\ServiceNotObject $e) {
    throw $e;
}
