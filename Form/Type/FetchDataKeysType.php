<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FetchDataKeysType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
            'prototype'    => true
        ));
    }

    public function getParent()
    {
        return 'collection';
    }

    public function getName()
    {
        return 'fetch_data_keys_type';
    }
}