<?php

namespace Hatimeria\DotpayBundle\Form\Handler;

use Symfony\Component\Routing\Router;
use Symfony\Component\Form\Form;
use Symfony\Bridge\Monolog\Logger;

class RequestFormHandler
{
    /**
     * @var \Symfony\Component\Form\Form
     */
    protected $form;
    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    protected $logger;
    /**
     * @var \Symfony\Component\Routing\Router
     */
    protected $router;
    /**
     * @var array
     */
    protected $defaults;

    public function __construct(Form $form, Logger $logger, Router $router, array $defaults)
    {
        $this->form     = $form;
        $this->logger   = $logger;
        $this->router   = $router;
        $this->defaults = $defaults;
    }

    public function process($data)
    {
        $mergedData = array_merge($this->defaults, $data);

        // generating urls
        if (isset($mergedData['url']) && $mergedData['url'] && (strpos($mergedData['url'], '/') === false)) {
            $url = $this->router->generate($mergedData['url'], array(), true);
            $mergedData['url'] = $url;
        }
        if (isset($mergedData['urlc']) && $mergedData['urlc'] && (strpos($mergedData['urlc'], '/') === false)) {
            $urlc = $this->router->generate($mergedData['urlc'], array(), true);
            $mergedData['urlc'] = $urlc;
        }

        $form = $this->form;
        $form->bind($mergedData);

        if (!$form->isValid()) {
            $errors = array();
            foreach($form->getErrors() as $error) {
                /* @var \Symfony\Component\Form\FormError $error */
                $errors[] = $error->getMessageTemplate();
            }
            
            $logger = $this->logger;
            $logger->err('Params: ' . json_encode($mergedData));
            $logger->err('Errors: ' . json_encode($errors));

            throw new \InvalidArgumentException('Invalid action parameters. Check profiler log information for more details');
        }

        return $form;
    }

}
 
