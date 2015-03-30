<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TemplateType
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\Form
 */
class TemplateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('tags', 'related_to_many_metadata_tags');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Tms\Bundle\DocumentGeneratorBundle\Entity\Template',
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'template';
    }
}
