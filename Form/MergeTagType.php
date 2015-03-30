<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class MergeTagType
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\Form
 */
class MergeTagType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identifier')
            ->add('required', 'checkbox', array('required' => false))
            ->add('description')
            ->add('defaultValue')
            ->add('fetcherAlias', 'fetcher_alias');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag',
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'template_mergetag';
    }
}
