<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @licence MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditorTemplateType extends TemplateType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('name')
            ->remove('description')
            ->add('html', 'ace_textarea', array(
                'required'      => false,
                'editor_mode'   => 'html',
                'editor_height' => 600
            ))
            ->add('css', 'ace_textarea', array(
                'required'      => false,
                'editor_mode'   => 'css',
                'editor_height' => 600
            ))
            ->add('mergeTags')
        ;
    }

    public function getName()
    {
        return 'tms_bundle_documentgeneratorbundle_editortemplatetype';
    }
}
