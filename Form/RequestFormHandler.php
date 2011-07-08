<?php

namespace Hatimeria\DotpayBundle\Form;

use Symfony\Component\Form\Form;
use \Symfony\Bridge\Monolog\Logger;

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
     * @var array
     */
    protected $defaults;

    public function __construct(Form $form, Logger $logger, array $defaults)
    {
        $this->form     = $form;
        $this->logger   = $logger;
        $this->defaults = $defaults;
    }

    public function process($data)
    {
        $mergedData = array_merge($this->defaults, $data);
        $form       = $this->form;
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
 
