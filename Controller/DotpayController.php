<?php

namespace Hatimeria\DotpayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Hatimeria\DotpayBundle\Response\ResponseManagerInterface;

class DotpayController extends Controller
{
    public function executeAction($params = array())
    {
        /* @var \Symfony\Component\DependencyInjection\Container $container */
        $container = $this->container;

        /* @var \Hatimeria\DotpayBundle\Form\RequestFormHandler $handler */
        /* @var \Symfony\Component\Form\Form $form */
        $handler = $this->get('hatimeria_dotpay.request.form.handler');
        $form    = $handler->process($params);

        return $this->render('HatimeriaDotpayBundle:Dotpay:execute.html.twig', array(
            'form'              => $form->createView(),
            'dotpay_secure_url' => $container->getParameter('hatimeria_dotpay.secure_url'),
            'submit_idle'       => $container->getParameter('hatimeria_dotpay.request.submit_idle'),
        ));
    }

    public function responseAction()
    {
        /* @var \Hatimeria\DotpayBundle\Form\ResponseFormHandler $handler */
        /* @var \Hatimeria\DotpayBundle\Response\ResponseManager $manager */
        $handler  = $this->get('hatimeria_dotpay.response.form.handler');
        $response = $handler->process();
        $manager  = $this->get('hatimeria_dotpay.response.manager');

        if (!($manager instanceof ResponseManagerInterface)) {
            throw new \InvalidArgumentException('hatimeria_dotpay.response.manager must implement Hatimeria\DotpayBundle\Response\ResponseManagerInterface');
        }
        if ($manager->execute($response)) {
            return new Response('OK', 200);
        }

        return new Response('FAIL', 200);
    }

}