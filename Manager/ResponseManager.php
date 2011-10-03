<?php

namespace Hatimeria\DotpayBundle\Manager;

class ResponseManager extends BaseManager
{
    /**
     * @param \Hatimeria\DotpayBundle\Response\Response $response
     * 
     * @return bool
     */
    protected function validate($response)
    {
        $conf   = $this->configuration;
        $logger = $this->logger;

        if ($conf['id'] != $response->id) {
            $logger->err(sprintf('DotpayBundle: We received response with incorrect id value got: "%s" expected: "%s"', $response->id, $conf['id']));

            return false;
        }
        if ($response->status != "OK") {
            $logger->err('DotpayBundle: There were some problems during dotpay.pl payment process');

            return false;
        }
        if (!$conf['test_mode'] && (strpos($response->t_id, 'TST') !== false)) {
            $logger->err('DotpayBundle: We have received test transaction and hatimeria_dotpay.test_mode parameter is set to false');

            return false;
        }

        $phrase = 'PIN:id:control:t_id:amount:email:service:code:username:password:t_status';
        $map = array(
            'PIN'      => (isset($conf['pin']) ? $conf['pin'] : ''),
            'id'       => $response->id,
            'control'  => $response->control,
            't_id'     => $response->t_id,
            'amount'   => $response->amount,
            'email'    => $response->email,
            'service'  => $response->service,
            'code'     => $response->code,
            'username' => $response->username,
            'password' => $response->password,
            't_status' => $response->t_status,
        );
        $phrase = strtr($phrase, $map);

        if ($response->md5 !== md5($phrase)) {
            $logger->err('DotpayBundle: md5 checksum was incorrect');

            return false;
        }

        return true;
    }

}