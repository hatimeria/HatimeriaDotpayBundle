<?php

namespace Hatimeria\DotpayBundle\Event;

use \Hatimeria\DotpayBundle\Response\Response;

class ValidationEvent extends Event
{
    public function __construct(Response $response)
    {
        parent::__construct($response);

        $this->result = false;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return true === $this->getResult();
    }

    public function markAsValid()
    {
        $this->setResult(true);
    }

    public function markAsInvalid()
    {
        $this->setResult(false);
    }

}