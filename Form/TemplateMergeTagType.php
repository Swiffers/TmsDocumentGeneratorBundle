<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Tms\Bundle\DocumentGeneratorBundle\Exception\MissingRelatedEntityException;

class TemplateMergeTagType extends MergeTagType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $template = $builder->getData()->getTemplate();
        if(!$template) {
            throw new MissingRelatedEntityException('MergeTag', $this);
        }
        parent::buildForm($builder, $options);
        $builder
            ->remove('template')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tms_bundle_documentgeneratorbundle_templatemergetagtype';
    }
}
