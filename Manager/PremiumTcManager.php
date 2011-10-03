<?php

namespace Hatimeria\DotpayBundle\Manager;

use Hatimeria\DotpayBundle\Request\PremiumTc;

class PremiumTcManager extends BaseManager
{
    /**
     * @param \Hatimeria\DotpayBundle\Request\PremiumTc $request
     * @return bool
     */
    public function validate($request)
    {
        $config = $this->configuration;
        $logger = $this->logger;

        $map = array(
            'id'       => $config['id'],
            'PIN'      => (isset($config['pin']) ? $config['pin'] : ''),
            'ident'    => $request->ident,
            'service'  => $request->service,
            'number'   => $request->number,
            'sender'   => $request->sender,
            'code'     => $request->code,
            'date'     => $request->date,
            'fulltext' => $request->fulltext,
        );
        $phrase = implode('', $map);

        if ($request->md5 !== md5($phrase)) {
            $logger->err('DotpayBundle: premium tc md5 checksum was incorrect');

            return false;
        }

        return true;
    }

}