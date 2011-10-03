<?php

namespace Hatimeria\DotpayBundle\Event;

class ValidationEvent extends Event
{
    public function __construct($subject)
    {
        parent::__construct($subject);

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