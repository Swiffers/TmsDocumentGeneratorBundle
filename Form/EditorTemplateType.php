<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class EditorTemplateType extends TemplateType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $mergeTags = array();
        foreach($form->getData()->getMergeTags() as $mergeTag) {
            $mergeTags[] = $mergeTag->getIdentifier();
        }

        $view->vars = array_merge($view->vars, array(
            'merge_tags' => $mergeTags,
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('name')
            ->remove('description')
            ->add('html', 'ace_textarea', array(
                'required'      => false,
                'editor_mode'   => 'html',
                'editor_height' => '800',
                'editor_width'  => '100%'
            ))
            ->add('css', 'ace_textarea', array(
                'required'      => false,
                'editor_mode'   => 'css',
                'editor_height' => '800',
                'editor_width'  => '100%'
            ))
        ;
    }

    public function getName()
    {
        return 'tms_bundle_documentgeneratorbundle_editortemplatetype';
    }
}
