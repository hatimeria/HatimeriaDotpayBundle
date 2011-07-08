<?php

namespace Hatimeria\DotpayBundle\Response;

interface ResponseManagerInterface
{
    /**
     * @abstract
     * @param Response $data
     * @return bool
     */
    public function execute(Response $response);
}