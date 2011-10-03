<?php

namespace Hatimeria\DotpayBundle\Manager;

use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Hatimeria\DotpayBundle\Event\ManagerEvents as Events;
use Hatimeria\DotpayBundle\Event\ValidationEvent;
use Hatimeria\DotpayBundle\Event\Event;
use Hatimeria\DotpayBundle\Response\Response;

abstract class BaseManager implements ManagerInterface
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
     * @return bool
     */
    public function execute($subject)
    {
        $this->logger->info('DotpayManager [Response]: ' . json_encode($subject));

        $event = new ValidationEvent($subject);
        $this->dispatcher->dispatch(Events::PRE_VALIDATE, $event);

        if ($event->isExecuted() && !$event->isValid()) {
            $this->logger->err('DotpayManager: execution failed during hatimeria_dotpay.pre_validate event');

            return false;
        }
        $result = $this->validate($subject);
        if (!$result) {
            $this->logger->err('DotpayManager: Response validation failed');

            return false;
        }

        $event = new Event($subject);
        $this->dispatcher->dispatch(Events::EXECUTION, $event);

        if (!$event->isExecuted()) {
            $this->logger->err('DotpayManager: No event found executing payment finalization process');

            return false;
        }
        if (!$event->getResult()) {
            $this->logger->err('DotpayManager: hatimeria_dotpay.execution event finished with result false. Check logs for more information');

            return false;
        }

        return true;
    }

    abstract protected function validate($response);
}