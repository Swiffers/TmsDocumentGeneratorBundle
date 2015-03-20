<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Tms\Bundle\DocumentGeneratorBundle\Form\Type\FetchDataKeysType;

class MergeTagType extends AbstractType
{
    private $fetcherAlias;

    public function __construct(array $fetcherAlias = null)
    {
        $this->fetcherAlias = $fetcherAlias;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identifier', 'text', array('label' => 'identifier *'))
            ->add('required', 'checkbox', array('required' => false, 'label' => 'required *', 'data' => true))
            ->add('description', 'text', array('required' => false))
            ->add('defaultValue', 'text', array('required' => false))
            ->add('fetcherAlias', 'choice', array(
                'choices' => array_combine($this->fetcherAlias, $this->fetcherAlias),
                'label' => 'fetcherAlias *'
            ))
            ->add('fetchDataKeys', new FetchDataKeysType())
            //->add('template_id')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'template_mergetag';
    }
}
