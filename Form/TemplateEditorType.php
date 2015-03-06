<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TemplateEditorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'text')
            ->add('tags')
            ->add('html', 'textarea')
            ->add('css', 'textarea')
            ->add('mergeTags')
            ->add('images')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'editor';
    }
}
