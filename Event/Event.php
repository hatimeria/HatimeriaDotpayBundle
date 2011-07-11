<?php

namespace Hatimeria\DotpayBundle\Event;

use Symfony\Component\EventDispatcher\Event as BaseEvent;

use Hatimeria\DotpayBundle\Response\Response;

class Event extends BaseEvent
{
    /**
     * @var \Hatimeria\DotpayBundle\Response\Response
     */
    protected $response;
    /**
     * @var bool
     */
    protected $executed = false;

    protected $result;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return \Hatimeria\DotpayBundle\Response\Response
     */
    public function getResponse()
    {
        return $this->response;
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