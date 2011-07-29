<?php

namespace Hatimeria\DotpayBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Hatimeria\FrameworkBundle\Form\EventListener\RemoveExtraDataListener;

class ResponseFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('id', 'text');
        $builder->add('status', 'text');
        $builder->add('control', 'text');
        $builder->add('t_id', 'text');
        $builder->add('amount', 'text');
        $builder->add('orginal_amount', 'text');
        $builder->add('email', 'text');
        $builder->add('service', 'text');
        $builder->add('code', 'text');
        $builder->add('username', 'text');
        $builder->add('password', 'text');
        $builder->add('t_status', 'text');
        $builder->add('description', 'text');
        $builder->add('md5', 'text');
        $builder->add('p_info', 'text');
        $builder->add('p_email', 'text');
        $builder->add('t_date', 'text');

        $builder->addEventSubscriber(new RemoveExtraDataListener());
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    function getName()
    {
        return 'response';
    }
}