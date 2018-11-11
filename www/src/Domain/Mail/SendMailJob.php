<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Domain\Mail;

use Core\Interfaces\JobInterface;
use Core\Mail\Mailer;
use Domain\Mail\Mapper\MailMapper;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

/**
 * Class SendMail
 *
 * @package Domain\Jobs
 */
class SendMailJob implements JobInterface
{
    /** @var ContainerInterface */
    protected $container;

    /** @var Logger $log */
    protected $log;

    /** @var bool */
    public $mailWasSend = false;

    /**
     * @var null
     */
    public $errorInfo = null;

    /**
     * SendMail constructor.
     *
     * @param ContainerInterface $container
     *
     * @param Logger             $log
     */
    public function __construct(ContainerInterface $container, Logger $log)
    {
        $this->container = $container;
        $this->log       = $log;
    }

    /**
     * @param array $args
     *
     * @return bool|mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function job(array $args)
    {
        /** @var Mailer $coreMail */
        $coreMail = $this->container->get('mail');

        /** @var \PHPMailer $mailer */
        $mailer = $coreMail->getMailer();

        $mailMapper = new MailMapper();
        $mail       = $mailMapper->getFilledModel($args);

        $mailer->addAddress($mail->getTo());
        $mailer->Subject = $mail->getSubject();
        $mailer->Body    = $mail->getMessage();

        try {
            $result = $mailer->send();
        } catch (\Exception $ex) {
            $this->log->addError($ex->getMessage(), (array)$ex);

            return false;
        }

        if (!empty($mailer->ErrorInfo)) {
            $this->errorInfo = $mailer->ErrorInfo;
        } else {

            $this->mailWasSend = true;

            $this->log->addInfo('Mail was sent');
        }

        return $this->mailWasSend;
    }
}
