<?php

namespace Hatimeria\DotpayBundle\Event;

class ValidationEvent extends Event
{
    /**
     * @var bool
     */
    protected $result = false;

    /**
     * @param bool $result
     * @return void
     */
    public function setValid($result)
    {
        $this->executed = true;

        $this->result = $result;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return true === $this->result;
    }

}