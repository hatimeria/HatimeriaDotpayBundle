HatimeriaDotpayBundle
============

HatimeriaDotpayBundle is Symfony2 bundle which integrates with Dotpay payment system

::

    return $this->forward('HatimeriaDotpayBundle:Dotpay:execute', array('params' => array(
        'amount' => 1000,
        'control' => md5('lol')
    )));