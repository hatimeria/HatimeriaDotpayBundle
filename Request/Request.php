<?php

namespace Hatimeria\DotpayBundle\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Request
{
    /**
     * @Assert\NotBlank(message="Id parameter is required")
     * @var int
     */
    public $id;
    /**
     * @Assert\NotBlank(message="Amount parameter is required")
     * @var float
     */
    public $amount;
    /**
     * @Assert\NotBlank(message="Description parameter is required")
     * @var string
     */
    public $description;
    /**
     * @var string
     */
    public $url;
    /**
     * @var string
     */
    public $urlc;
    /**
     * @var int
     */
    public $type;
    /**
     * @var string
     */
    public $buttontext;
    /**
     * @Assert\NotBlank(message="Control parameter is required")
     * @var
     */
    public $control;
    /**
     * @var
     */
    public $firstname;
    /**
     * @var
     */
    public $lastname;
    /**
     * @var
     */
    public $email;
    /**
     * @var
     */
    public $street;
    /**
     * @var
     */
    public $streetn1;
    /**
     * @var
     */
    public $streetn2;
    /**
     * @var
     */
    public $city;
    /**
     * @var
     */
    public $code;

}