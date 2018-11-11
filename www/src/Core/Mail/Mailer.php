<?php
/**
 * @project: sender
 * @author : baster <rbaster@yandex.ru>
 * @site   : https://rbaster.ru
 * @version: 1
 */

namespace Core\Mail;

/**
 * Class Mailer
 *
 * @package Core\Mail
 */
class Mailer
{
    /**
     * @var
     */
    protected $mailer;

    /**
     * @var
     */
    protected $container;

    /**
     * Mailer constructor.
     *
     * @param $mailer
     * @param $container
     */
    public function __construct($mailer, $container)
    {
        $this->mailer    = $mailer;
        $this->container = $container;
    }

    /**
     * @return mixed
     */
    public function getMailer()
    {
        return $this->mailer;
    }
}