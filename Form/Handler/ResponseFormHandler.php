<?php

namespace Hatimeria\DotpayBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Monolog\Logger;

use Hatimeria\DotpayBundle\Response\Response;

class ResponseFormHandler
{
    /**
     * @var \Symfony\Component\Form\Form
     */
    protected $form;
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;
    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    protected $logger;

    public function __construct(Form $form, Request $request, Logger $logger)
    {
        $this->form    = $form;
        $this->request = $request;
        $this->logger  = $logger;
    }

    /**
     * @throws \InvalidArgumentException
     * @return \Hatimeria\DotpayBundle\Response\Response
     */
    public function process()
    {
        $data = $this->request->request->all();
        $form = $this->form;
        $form->bind($data);

        if (!$form->isValid()) {
            $errors = array();
            foreach($form->getChildren() as $field) {
                if (!$field->hasErrors()) continue;
                $errors[] = $field->getName();
            }

            $logger = $this->logger;
            $logger->err('Params: ' . json_encode($data));
            $logger->err('Missing parameters: ' . json_encode($errors));

            throw new \InvalidArgumentException('Response failed during validation.
            Check if your response object is well constructed or update your form type class');
        }

        return $form->getData();
    }

}
 
