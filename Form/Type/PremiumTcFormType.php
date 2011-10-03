<?php

namespace Hatimeria\DotpayBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Hatimeria\FrameworkBundle\Form\EventListener\RemoveExtraDataListener;

class PremiumTcFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('fulltext', 'text');
        $builder->add('text', 'text');
        $builder->add('ident', 'text');
        $builder->add('service', 'text');
        $builder->add('number', 'text');
        $builder->add('sender', 'text');
        $builder->add('code', 'text');
        $builder->add('date', 'text');
        $builder->add('md5', 'text');

        $builder->addEventSubscriber(new RemoveExtraDataListener());
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    function getName()
    {
        return 'premium_tc';
    }
}