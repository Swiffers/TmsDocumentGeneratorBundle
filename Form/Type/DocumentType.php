<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            //->add('tags')
            ->add('save', 'submit')
        ;
    }

    public function getName()
    {
        return 'document';
    }
}
