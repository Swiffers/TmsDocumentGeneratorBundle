<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TemplateConfigurationTagType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('configurationTags',
            'entity', array(
                'class' => 'TmsDocumentGeneratorBundle:ConfigurationTag',
                'property' => 'name',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tms\Bundle\DocumentGeneratorBundle\Entity\Template'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tms_bundle_documentgeneratorbundle_templateconfigurationtagtype';
    }
}
