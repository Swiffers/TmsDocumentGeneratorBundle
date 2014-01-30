<?php

/**
 * @author Jean-Philippe Chateau <jp.chateau@trepia.fr>
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AceTextareaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'editor_width'       => 'auto',
            'editor_height'      => 'auto',
            'editor_mode'        => 'html',
            'editor_theme'       => 'github',
            'editor_show_gutter' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge($view->vars, array(
            'editor_width'       => $options['editor_width'],
            'editor_height'      => $options['editor_height'],
            'editor_mode'        => $options['editor_mode'],
            'editor_theme'       => $options['editor_theme'],
            'editor_show_gutter' => $options['editor_show_gutter'],
        ));
    }

    public function getName()
    {
        return 'ace_textarea';
    }

    public function getParent()
    {
        return 'textarea';
    }
}
