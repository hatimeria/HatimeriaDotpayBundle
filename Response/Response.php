<?php

namespace Hatimeria\DotpayBundle\Response;

use Symfony\Component\Validator\Constraints as Assert;

class Response
{
    /**
     * @Assert\NotBlank(message="Required")
     */
    public $id;
    /**
     * @Assert\NotBlank(message="Required")
     */
    public $status;
    /**
     * @Assert\NotBlank(message="Required")
     */
    public $control;
    /**
     * @Assert\NotBlank(message="Required")
     */
    public $amount;
    /**
     * @Assert\NotBlank(message="Required")
     */
    public $orginal_amount;

    public $email;
    /**
     * @Assert\NotBlank(message="Required")
     */
    public $t_status;

    public $description;
    /**
     * @Assert\NotBlank(message="Required")
     */
    public $md5;

    public $t_date;
    /**
     * @Assert\NotBlank(message="Required")
     */
    public $t_id;

    public $service;

    public $code;

    public $username;

    public $password;

    public $p_info;

    public $p_email;

    public function isStatusMade()
    {
        return ResponseStatus::MADE === (int)$this->t_status;
    }

    public function getStatus()
    {
        return $this->t_status;
    }

    public function getControl()
    {
        return $this->control;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getTransactionDate()
    {
        return $this->t_date;
    }

    public function getOrginalAmount()
    {
        return $this->orginal_amount;
    }

    public function getTransactionId()
    {
        return $this->t_id;
    }
}