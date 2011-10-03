<?php

namespace Hatimeria\DotpayBundle\Event;

use Symfony\Component\EventDispatcher\Event as BaseEvent;

use Hatimeria\DotpayBundle\Response\Response;

class Event extends BaseEvent
{
    protected $subject;
    /**
     * @var bool
     */
    protected $executed = false;

    protected $result;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return bool
     */
    public function isExecuted()
    {
        return true === $this->executed;
    }

    public function markAsExecuted()
    {
        $this->executed = true;
    }

    public function setResult($v)
    {
        $this->markAsExecuted();

        $this->result = $v;
    }

    public function getResult()
    {
        return $this->result;
    }

}