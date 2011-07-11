<?php

namespace Hatimeria\DotpayBundle\Response;

use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Hatimeria\DotpayBundle\Event\ResponseManagerEvents as Events;
use Hatimeria\DotpayBundle\Event\ValidationEvent;
use Hatimeria\DotpayBundle\Event\Event;

class ResponseManager implements ResponseManagerInterface
{
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $dispatcher;
    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    protected $logger;
    /**
     * @var array
     */
    protected $configuration;

    public function __construct(EventDispatcherInterface $dispatcher, Logger $logger, $configuration)
    {
        $this->dispatcher    = $dispatcher;
        $this->logger        = $logger;
        $this->configuration = $configuration;
    }

    /**
     * @param Response $data
     * @return bool
     */
    public function execute(Response $response)
    {
        $this->logger->info('ResponseManager [Response]: ' . json_encode($response));

        $event = new ValidationEvent($response);
        $this->dispatcher->dispatch(Events::PRE_VALIDATE, $event);

        if ($event->isExecuted() && !$event->isValid()) {
            $this->logger->err('ResponseManager: execution failed during hatimeria_dotpay.pre_validate event');

            return false;
        }
        $result = $this->validate($response);
        if (!$result) {
            $this->logger->err('ResponseManager: Response validation failed');
            
            return false;
        }
        
        $event = new Event($response);
        $this->dispatcher->dispatch(Events::EXECUTION, $event);

        if (!$event->isExecuted()) {
            $this->logger->err('ResponseManager: No event found executing payment finalization process');

            return false;
        }
        if (!$event->getResult()) {
            $this->logger->err('ResponseManager: hatimeria_dotpay.execution event finished with result false. Check logs for more information');

            return false;
        }
        
        return true;
    }

    protected function validate(Response $response)
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
        if (!$conf['test_mode'] && ($response->t_id === 'TST')) {
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