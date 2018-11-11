<?php

namespace Domain\Mail\Model;

use Core\Model\AbstractModel;

/**
 * Class DataModel
 *
 * @package Domain\Data\Model
 */
class MailModel extends AbstractModel
{
    /**
     * @var
     */
    protected $to;

    /**
     * @var
     */
    protected $subject;

    /**
     * @var
     */
    protected $message;

    /**
     * @var
     */
    protected $from;


    /**
     * @param array $params [description]
     */
    public function __construct(array $params = [])
    {
        $this->setOptions($params);
    }

    /**
     *
     * @param array $params
     */
    public function setOptions(array $params): void
    {
        foreach ($params as $key => $value) {
            switch ($key) {
                case 'to':
                    $this->setTo($value);
                    break;
                case 'from':
                    $this->setFrom($value);
                    break;
                case 'message':
                    $this->setMessage($value);
                    break;
                case 'subject':
                    $this->setSubject($value);
                    break;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to): void
    {
        $this->to = $to;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from): void
    {
        $this->from = $from;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }
}
