<?php

namespace Hatimeria\DotpayBundle\Manager;

interface ManagerInterface
{
    /**
     * @abstract
     * @param Response $data
     * @return bool
     */
    public function execute($response);
    
}