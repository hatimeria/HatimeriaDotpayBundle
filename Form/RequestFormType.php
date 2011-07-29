<?php

namespace Hatimeria\DotpayBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

use Hatimeria\FrameworkBundle\Form\EventListener\RemoveExtraDataListener;

class RequestFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('amount', 'hidden');
        $builder->add('description', 'hidden');
        $builder->add('url', 'hidden');
        $builder->add('urlc', 'hidden');
        $builder->add('type', 'hidden');
        $builder->add('buttontext', 'hidden');
        $builder->add('control', 'hidden');
        $builder->add('firstname', 'hidden');
        $builder->add('lastname', 'hidden');
        $builder->add('email', 'hidden');
        $builder->add('street', 'hidden');
        $builder->add('streetn1', 'hidden');
        $builder->add('streetn2', 'hidden');
        $builder->add('city', 'hidden');
        $builder->add('code', 'hidden');

        $builder->addEventSubscriber(new RemoveExtraDataListener());
    }

    public function buildViewBottomUp(FormView $view, FormInterface $form)
    {
        foreach ($view->getChildren() as $child)
        {
            /* @var \Symfony\Component\Form\FormView $child */
            $child->set('full_name', $child->get('name'));
        }
    }

    function getName()
    {
        return 'request';
    }
}